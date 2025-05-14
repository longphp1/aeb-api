<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeInfo;
use App\Http\Resources\NoticeList;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\NoticeService;
use Illuminate\Http\Request;

class NoticeController extends Controller
{

    protected $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }


    public function index()
    {
        return NoticeList::make($this->noticeService->index())->additional(Code::SUCCESS);
    }

    public function show($id)
    {
        return NoticeInfo::make($this->noticeService->show($id))->additional(Code::SUCCESS);
    }

    public function store(Request $request)
    {
        if ($this->noticeService->store($request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function update($id, Request $request)
    {
        if ($this->noticeService->update($id, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function destroy($ids)
    {
        if ($this->noticeService->destroy($ids)) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function publish($id)
    {
        return ApiResponseService::success($this->noticeService->publish($id));
    }

    public function revoke($id)
    {
        return ApiResponseService::success($this->noticeService->revoke($id));
    }

}
