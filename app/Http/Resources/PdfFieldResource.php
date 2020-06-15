<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PdfFieldValueResource;

class PdfFieldResource extends JsonResource
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
            'fields_number' => $this->id,
            'fields_name' => $this->name,
            'fields_value' => PdfFieldValueResource::collection($this->whenLoaded('pdfFields')),
        ];
    }
}
