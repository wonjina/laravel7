<?php

namespace App\Http\Services;

use App\Models\BoardModel\Board;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Common\Helper\Constants\PagenateConstants;

class BoardService
{
    //boards
    public function index($type, array $param)
    {
        $boards = Board::where('type', $type)
                        ->orderBy('created_at', 'desc')
                        ->paginate(is_null($param[PagenateConstants::PAGE_SIZE_COLUMN_NAME]) ? 
                                                                    PagenateConstants::PAGE_SIZE : 
                                                                    $param[PagenateConstants::PAGE_SIZE_COLUMN_NAME]);
        $boards->withQueryString()->links();
        return $boards;
    }
    
    public function destroy($id)
    {
        if(Auth::user()->is_admin) {
            return Board::destroy($id);
        } else {
            return Board::where('id', $id)->where('email',Auth::user()->email)->delete();
        }
    }

    public function show($boardId)
    {
        $board = Board::with('qna')->findOrFail($boardId);
        if(!$this->checkPermission($board))
        {
            return response('failed permission', 401);
        }
        return $board;
    }

    public function store(array $param)
    {
        $user = Auth::user();
        $board = new Board;
        $board->init($param, $user);
        return $board->save();
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