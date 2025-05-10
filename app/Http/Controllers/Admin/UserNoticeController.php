<?php

namespace App\Http\Controllers\Admin;

use App\Services\ApiResponseService;
use App\Services\System\UserNoticeService;

class UserNoticeController
{

    private $userNoticeService;

    public function __construct(UserNoticeService $userNoticeService)
    {
        $this->userNoticeService = $userNoticeService;
    }

    public function myNotice()
    {
        return ApiResponseService::success($this->userNoticeService->getUnReadNotice());
    }
}
