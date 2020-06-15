<?php

namespace App\Models\PdfModel;

use Illuminate\Database\Eloquent\Model;

class PdfField extends Model
{
    
    protected $fillable = [
        'name',
    ];

    public function pdfs()
    {
        return $this->belongsTo('App\Models\PdfModel\Pdf');
    }

    public function pdfFieldValue()
    {
        return $this->hasMany('App\Models\PdfModel\PdfFieldValue');
    }
}
