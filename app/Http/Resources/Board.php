<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\QnA as QnaResource;

class Board extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'board_number' => $this->id,
            'subject' => $this->subject,
            'content' => $this->content,
            'writer' => $this->writer.'('.$this->email.')',
            'created_date' => $this->created_at,
            'public' => $this->private,
            'is_answer' => $this->is_boardable,
            'answer' => new QnaResource($this->whenLoaded('qna')),
        ];
    }
}
