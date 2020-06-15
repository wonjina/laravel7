<?php

namespace App\Models\PdfModel;

use Illuminate\Database\Eloquent\Model;

class PdfFieldValue extends Model
{
    protected $fillable = [
        'field_value',
    ];

    public function pdfFields()
    {
        return $this->belongsTo('App\Models\PdfModel\PdfField');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function pdfs()
    {
        return $this->belongsTo('App\Models\PdfModel\Pdf');
    }

    public function init(array $fieldValues)
    {
        $this->value = $qna['content'];
    }
}
