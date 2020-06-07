<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardModel\QnA;
use App\Http\Services\QnABoardService;

class QnABoardController extends Controller
{
    //질문에 대한 답변 리스트(여러개일경우)
    public function index(QnABoardService $board, $boardId)
    {
        return $board->index($boardId);
    }

    //쓰기
    public function store(QnABoardService $board, Request $req, $boardId)
    {
        $validatedData = $req->validate([
            'content' => 'required|string',
        ]);
        return $board->store($req->all(), $boardId);
    }

    //수정
    public function update(QnABoardService $board, $boardId, $id)
    {
        return 'QnA update'.$boardId.','.$id;
    }

    //삭제
    public function destroy(QnABoardService $board, $boardId)
    {
        return $board->destroy($boardId);
    }
}
