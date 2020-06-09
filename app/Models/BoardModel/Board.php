<?php

namespace App\Models\BoardModel;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\User;

class Board extends Model
{
    public function init(array $board, $user) {
        $this->subject = $board['subject'];
        $this->content = $board['content'];
        $this->type = $board['type'];
        $this->email = $user->email;
        $this->writer = $user->name;
    }
    public function qna()
    {
        return $this->hasOne(QnA::class);
    }
}
