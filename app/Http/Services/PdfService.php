<?php

namespace App\Http\Services;

use App\Models\PdfModel\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Common\Helper\Constants\PagenateConstants;

class PdfService
{
    public function index()
    {
        //get service list  GEt /services
    }

    public function store()
    {

    }

    public function getFieldList($pdfId)
    {

    }

    public function getFieldValue(array $fieldIds)
    {

    }

    public function update()
    {

    }

    public function destory()
    {

    }

    public function userServiceList()
    {
        // Get /services/users
    }

    public function changeWritePermission()
    {
        // put /services/users?
    }
}