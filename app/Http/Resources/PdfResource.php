<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PdfFieldResource;

class PdfResource extends JsonResource
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
            'pdf_number' => $this->id,
            'pdf_name' => $this->file_name,
            'pdf_description' => $this->description,
            'pdf_fields' => PdfFieldResource::collection($this->whenLoaded('pdfFields')),
        ];
    }
}
