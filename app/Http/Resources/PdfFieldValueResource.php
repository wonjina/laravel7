<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PdfFieldValueResource extends JsonResource
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
            'value_number' => $this->id,
            'value' => $this->name,
            'value_created_at' => $this->created_at,
            'value_updated_at' => $this->updated_at,
        ];
    }
}
