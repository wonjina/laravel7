<?php

namespace App\Http\Services;

use App\Models\BoardModel\Board;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BoardService
{
    //boards
    public function index($type)
    {
        return Board::where('type', $type)->get();
    }
        
    public function update(array $board)
    {
        return 'Board update...';
    }
    
    public function destroy($id)
    {
        return Board::where('id', $id)->where('email',Auth::user()->email)->delete();
        /*
        $board = Board::findOrFail($id);    //없으면 404

        if(Auth::user()->is_amin || Auth::user()->email == $board->email)  //작성자 이거나 관리자일 경우 삭제
        {
            return Board::destroy($id);
        }
        return response('failed permission', 401);
        */
    }

    public function store(array $param)
    {
        $user = Auth::user();
        $board = new Board;
        $board->init($param, $user);
        return $board->save();
    }

}