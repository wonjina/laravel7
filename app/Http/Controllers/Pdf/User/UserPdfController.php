<?php

namespace App\Http\Controllers\Pdf\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PdfModel\Pdf;
use App\Models\PdfModel\PdfField;
use App\Models\PdfModel\PdfFieldValue;
use App\Models\ServiceModel\PdfService;
use App\Models\ServiceModel\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PdfServiceResource;
use App\Http\Resources\PdfResource;

class UserPdfController extends Controller
{
    /*
     * Get 가입한 서비스 중 특정 서비스의 특정 pdf파일의 pdf필드 리스트와 입력한 value
    */
    public function show($userId, $serviceId, $pdfId)
    {
        /*
        if($userId != Auth::id() && !Auth::is_admin) {
            return response(401);
        }
        */
        $a = Pdf::with(['pdfFields' => function($query) use ($pdfId) {
                            $query->where('pdf_id', $pdfId);
                        },
                        'pdfFields.pdfFieldValue' => function($query) use ($userId) {
                            $query->where('user_id', $userId);
                        }])->where('service_id', $serviceId)->get();

        return PdfResource::collection($a);
    }

    /*
     * Put 가입한 서비스 중 특정 서비스의 특정 pdf파일의 pdf필드 값 수정
    */
    public function update(Request $req, $userId, $serviceId, $pdfId)
    {
        /*
        if($userId != Auth::id() && !Auth::is_admin) {
            return response(401);
        }
        */
        //$pdfFields = PdfField::whereIn('name', array_keys($req->all()))->select('id')->get();
        if(!UserService::where(['user_id' => $userId, 'service_id' => $serviceId])->select('write_permission')->firstOrFail()) {
            return response(401);
        }

        $count=0;
        $pdfFieldValue = PdfFieldValue::where('pdf_id', $pdfId)->whereIn('pdf_field_id', array_keys($req->all()));
        $reqValue = $req->all();
        foreach($pdfFieldValue as $value)
        {
            $value->value = trim($reqValue[$value->field_id]);
            if($value->save()) {
               ++$count;
                UserService::where(['user_id' => $userId, 'service_id' => $serviceId])->update(['updated_at' => strtotime("Now")]);
            }
        }
        return $count;
    }
}
