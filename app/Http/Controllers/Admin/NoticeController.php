<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Services\System\NoticeService;

class NoticeController   extends Controller
{

    protected $noticeService;
    public function __construct(NoticeService $noticeService){
        $this->noticeService = $noticeService;
    }
    public function getUnReadNotice(){
        return ApiResponseService::success($this->noticeService->getUnReadNotice());
    }
}
