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
    
    public function show($id)
    {
        //$board = Board::where('id', $id)->get();
        $board = Board::findOrFail($id);    //없으면 404
        if($board->private == 1) //비공개라면
        {
            $user = Auth::user();
            if($user->email != $board->email) 
            {
                return response('failed permission', 401);
            }
        }

        return $board;
    }

    public function destroy($id)
    {
        $permission = Auth::user()->roles->pluck('name')->first();        
        $board = Board::findOrFail($id);    //없으면 404

        if($permission == 'admin' || Auth::user()->email == $board->email)  //작성자 이거나 관리자일 경우 삭제
        {
            return Board::destroy($id);
        }
        return response('failed permission', 401);
    }

    public function store(array $param)
    {
        $user = Auth::user();
        $board = new Board;
        $board->init($param, $user);
        return $board->save();
    }

}