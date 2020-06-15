<?php

namespace App\Http\Controllers\Pdf\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PdfModel\Pdf;
use App\Models\PdfModel\PdfField;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{

    public function store(Request $req)
    {
        /*
        $validatedData = $req->validate([
            'pdf_files' => 'required|mine:pdf',
        ]);
        */
        
        $pdfList = array();
        $pdfFieldList = array();
        $pdfTestFieldList = array('field1', 'field2', 'field3');
        $pdfFileNames = array();

        $files = $req->file('pdf_files');
        $i = 0;
        foreach($files as $file)
        {
            $name = 'test_'.$i.'.pdf';
            $pdfFileNames[] = $name;
            $pdfList[] = array('file_name' => $name, 'service_id' => 1);
            $i=0;
            foreach($pdfTestFieldList as $item)
            {
                $pdfFieldList[] =array('name' => $item.'_'.$i++);
            }

            $file->move(public_path().'/pdfFiles/', $name);
            $i = 1;
        }

        if(Pdf::whereIn('file_name', $pdfFileNames)->exists()) {
            return response('Already exists files.', 400);
        } else {
            $data = Pdf::insert($pdfList);
            $pdfIds = Pdf::whereIn('file_name', $pdfFileNames)->select('id')->get();
        }

        $saveFieldList = array();
        foreach($pdfIds as $pdfId)
        {
            foreach($pdfFieldList as $field)
            {
                $field['pdf_id'] = $pdfId->id;
                $saveFieldList[] = $field;
            }
        }
        PdfField::insert($saveFieldList);
        return $data;
        
    }

    /*
     * Get Pdf Info & Pdf Field List
    */
    public function show($pdfId)
    {
        return Pdf::with('pdfFields')->where('id', $pdfId)->get();
    }

    public function storeFieldValues(Request $req)
    {
        $arr = $req->input('field_value_list');
        $pdfId = $req->input('pdf_id');
        $userId = Auth::id();
        $keys = array_keys($arr);
        $fieldList = PdfField::whereIn('name', $keys)
                                ->where('pdf_id', $pdfId)
                                ->select('id', 'name')
                                ->get();

        $fieldValues = array();
        foreach($fieldList as $field)
        {
            $fieldValues[] = array('value' => $arr[$field->name], 'user_id' => $userId, 'field_id' => $field->id);
        }
        PdfFieldValue::insert($fieldValues);
    }
}
