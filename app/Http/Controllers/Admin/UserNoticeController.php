<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\MyNoticeList;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\UserNoticeService;
use Illuminate\Support\Facades\Request;

class UserNoticeController
{

    private $userNoticeService;

    public function __construct(UserNoticeService $userNoticeService)
    {
        $this->userNoticeService = $userNoticeService;
    }

    public function myNotice(Request $request)
    {
        return MyNoticeList::make($this->userNoticeService->getUnReadNotice())->additional(Code::SUCCESS);
    }

    public function readAll(Request $request)
    {
        return ApiResponseService::success($this->userNoticeService->readAll(request()->all()));
    }
}
