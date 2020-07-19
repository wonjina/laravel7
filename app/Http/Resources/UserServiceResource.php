<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PdfServiceResource;
use App\Http\Resources\UserResource;

class UserServiceResource extends JsonResource
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
            'permission' => $this->write_permission,
            'joined_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'member' => $this->when($this->whenLoaded('user'), new UserResource($this->user)),
            'pdf_service' => $this->when($this->whenLoaded('pdfService'), new PdfServiceResource($this->pdfService)),
        ];
    }
}
