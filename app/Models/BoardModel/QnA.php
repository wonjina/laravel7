<?php

namespace App\Models\BoardModel;

use Illuminate\Database\Eloquent\Model;

class QnA extends Model
{
    public function init(array $qna, $user)
    {
        $this->content = $qna['content'];
        $this->respondent = $user->name.'('. $user->email.')';
        $this->board_id = $qna['board_id'];
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
