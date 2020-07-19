<?php

namespace App\Http\Controllers\Pdf\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ServiceModel\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserServiceResource;


class ServiceUserController extends Controller
{
    /*
    *   Get 최근 업데이트 순 유저 서비스 리스트
    */
    public function index()
    {
        //관리자인지 check
        $a = UserService::with(['user', 'pdfService'])->orderBy('updated_at', 'desc')->get();
        return UserServiceResource::collection($a);
    }

    /*
    *   Update 고객이 이용중인 서비스의 문서 수정 권한 수정
    */
    public function update(Request $req, $serviceId, $userId)
    {
        //관리자인지 check
        $permission = $req->input('permission');
        return UserServive::where(['service_id'=>$serviceId, 'user_id'=>$userId])->update(['write_permission',$permission]);
    }
}
