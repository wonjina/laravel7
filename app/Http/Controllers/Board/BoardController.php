<?php

namespace App\Http\Controllers\Board;

use Illuminate\Http\Request;
use App\Http\Services\BoardService;
use App\Http\Services\QnABoardService;
use App\Http\Services\pdfBoardService;
use Illuminate\Support\Facades\Log;
use App\Models\QnA;
use App\Http\Resources\Board as BoardResource;

class BoardController extends Controller
{
    //조회
    public function index(BoardService $board, Request $req) 
    {
        $validatedData = $req->validate([
            'page_size' => 'required|integer|min:1',
        ]);
        return BoardResource::collection($board->index($req->query('type'), $req->all()));
    }

    public function show(BoardService $board, $boardId) 
    {
        return new BoardResource($board->show($boardId));
    }

    //쓰기
    public function store(BoardService $board, Request $req) 
    {
        $validatedData = $req->validate([
            'subject' => 'bail|required|string',
            'content' => 'bail|required|string',
            'type' => 'bail|required|string',
            'private' => 'bail|required|boolean',
        ]);
        /*
throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
        */
        return $board->store($req->all());
    }

    //수정
    public function update(BoardService $board, Request $req) {
        return $board->update();
    }

    //삭제
    public function destroy(BoardService $board, $id) {
        return $board->destroy($id);
    }
}
