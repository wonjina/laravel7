<?php

namespace App\Models\ServiceModel;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function pdfService()
    {
        return $this->belongsTo('App\Models\ServiceModel\PdfService');
    }
}
