<?php

namespace App\Http\Services;

use App\Models\BoardModel\QnA;
use App\Models\BoardModel\Board;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class QnABoardService
{
    public function index($boardId)
    {
        $board = Board::with('qna')->findOrFail($boardId);
        if(!$this->checkPermission($board))
        {
            return response('failed permission', 401);
        }
        return $board;
    }

    public function destroy($boardId, $qnaId)
    {
        QnA::findOrFail($qnaId);
        return QnA::destroy($qnaId);
    }

    public function store(array $param, $boardId)
    {
        if(QnA::where('board_id', $boardId)->first())
        {
            return response('Already exist a answer', 400);
        }
        $qa = new QnA;
        $qa->init($param, Auth::user());
        return $qa->save();
    }

    private function checkPermission($board)
    {
        if($board->private) //비공개라면
        {
            if(!Auth::user()->is_admin && Auth::user()->email != $board->email) 
            {
                return false;
            }
        }
        return true;
    }
}