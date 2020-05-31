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
    private $test = 'QnA->';
    
    public function index($boardId)
    {
        //add validate check 
        return Board::with('qna')->where('id', $boardId)->get();
    }
        
    public function update(array $board)
    {
        return 'QnA update...';
    }
    
    public function show($boardId, $id)
    {
        $board = Board::findOrFail($boardId);    //없으면 404
        if($board->private == 1) //비공개라면
        {
            if(Auth::user()->email != $board->email) 
            {
                return response('failed permission', 401);
            }
        }

        return QnA::with('board')
                    ->where([
                        ['id', $id],
                        ['board_id', $boardId]
                    ])->get();
    }

    public function destroy($boardId, $id)
    {
        return QnA::destroy($id);
    }

    public function store(array $param, $boardId)
    {
        $user = Auth::user();
        $qa = new QnA;
        $qa->init($param, $user);
        return $qa->save();
    }
}