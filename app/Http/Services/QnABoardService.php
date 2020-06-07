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
        if(!$this->checkPermission($boardId))
        {
            return response('failed permission', 401);
        }
        return Board::with('qna')->where('id', $boardId)->get();
    }
        
    public function update(array $board)
    {
        return 'QnA update...';
    }

    public function show($boardId, $id)
    {
        if(!$this->checkPermission($boardId))
        {
            return response('failed permission', 401);
        }
        return QnA::where('id', $id)->get();
    }

    public function destroy($boardId, $id)
    {
        return QnA::destroy($id);
    }

    public function store(array $param, $boardId)
    {
        $qa = new QnA;
        $qa->init($param, Auth::user());
        return $qa->save();
    }

    private function checkPermission($boardId)
    {
        $board = Board::findOrFail($boardId);    //없으면 404
        if($board->private) //비공개라면
        {
            if(!Auth::user()->is_admin) {Log::debug('message  '.Auth::user()->email .'---'. $board->email);}
            if(!Auth::user()->is_admin && Auth::user()->email != $board->email) 
            {
                return false;
            }
        }
        return true;
    }
}