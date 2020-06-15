<?php

namespace App\Models\PdfModel;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    
    protected $fillable = [
        'name', 'description',
    ];

    public function pdfService()
    {
        return $this->belongsTo('App\Models\ServiceModel\PdfService');
    }

    public function pdfFields()
    {
        return $this->hasMany('App\Models\PdfModel\PdfField');
    }

    public function pdfFieldValues()
    {
        return $this->hasMany('App\Models\PdfModel\PdfFieldValue');
    }
}
