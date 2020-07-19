<?php

namespace App\Models\ServiceModel;

use Illuminate\Database\Eloquent\Model;

class PdfService extends Model
{
    public function pdfs()
    {
        return $this->hasMany('App\Models\PdfModel\Pdf');
    }
    
    public function userServices()
    {
        return $this->hasMany('App\Models\ServiceModel\UserService');
    }
}
