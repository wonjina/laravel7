<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QnA extends JsonResource
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
            'content' => $this->content,
            'respondent' => $this->respondent,
            'created_date' => $this->created_at,
        ];
    }
}
