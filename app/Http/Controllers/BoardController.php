<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BoardService;
use App\Http\Services\QnABoardService;
use App\Http\Services\pdfBoardService;
use Illuminate\Support\Facades\Log;
use App\Models\QnA;

class BoardController extends Controller
{
    
    function __construct(Request $req)
    {
        /*
        Log::info('BoardController: __construct: '.$req->query('type'));
        if($req->query('type')=='pdf') {
            app()->bind(BoardServiceInterface::class, BoardService::class);
        } else {
            app()->bind(BoardServiceInterface::class, QnABoardService::class);
        }
        */
    }

    //조회
    public function index(BoardService $board, Request $req) 
    {
        return $board->index($req->query('type'));
    }

    public function show(BoardService $board, $id) 
    {
        return $board->show($id);
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
