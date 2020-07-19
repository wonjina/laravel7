<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserServiceResource;

class PdfServiceResource extends JsonResource
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
            'number' => $this->id,
            'name' => $this->name,
            'depth' => $this->depth,
            'parent_number' =>$this->parents_id,
            'user_info' => UserServiceResource::collection($this->whenLoaded('userServices')),
        ];
    }
}
