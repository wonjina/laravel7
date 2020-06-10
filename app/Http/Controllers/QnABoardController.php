<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardModel\QnA;
use App\Http\Services\QnABoardService;
use App\Http\Resources\Board as BoardResource;
use App\Http\Resources\QnA as QnAResource;

class QnABoardController extends Controller
{
    //질문에 대한 답변 리스트(여러개일경우)
    public function index(QnABoardService $board, $boardId)
    {
        return BoardResource::collection($board->index($boardId));
    }

    //쓰기
    public function store(QnABoardService $board, Request $req, $boardId)
    {
        $validatedData = $req->validate([
            'content' => 'required|string',
        ]);
        return new QnAResource($board->store($req->all(), $boardId));
    }

    //삭제
    public function destroy(QnABoardService $board, $boardId)
    {
        return $board->destroy($boardId);
    }
}
