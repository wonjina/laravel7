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

class UserServiceController extends Controller
{
    
    /*
     * Get 유저가 가입한 서비스 리스트
    */
    public function index($userId)
    {
        /*
        if($userId != Auth::id() && !Auth::is_admin) {
            return response(401);
        }
        */
        
        //성능 이슈 발생 시 튜닝하기
        $a = PdfService::with(['userServices' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get(); 
        return PdfServiceResource::collection($a);
    }

    
    /*
     * Get 가입한 서비스 중 특정 서비스의 pdf필드 리스트와 입력한 value
    */
    public function show($userId, $serviceId)
    {
        /*
        if($userId != Auth::id() && !Auth::is_admin) {
            return response(401);
        }
        */
        $a = Pdf::with(['pdfFields',
                        'pdfFields.pdfFieldValue' => function($query) use ($userId) {
                            $query->where('user_id', $userId);
                        }])->where('service_id', $serviceId)->get();

        return PdfResource::collection($a);
    }

    
    /*
     * Delete 가입한 서비스 중 특정 서비스의 pdf필드 리스트와 입력한 value
    */
    public function destory($userId, $serviceId)
    {
        /*
        if($userId != Auth::id() && !Auth::is_admin) {
            return response(401);
        }
        */
        UserService::where(['user_id'=> $userId, 'service_id' => $serviceId])->destroy();
        $pdfId = Pdf::where('service_id', $serviceId)->select('id')->firstOrFail();
        PdfFieldValue::where(['user_id'=>$userId, 'pdf_id'=>$pdfId])->destroy();
    }
}
