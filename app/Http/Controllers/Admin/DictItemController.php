<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DictItemInfo;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\DictItemService;
use Illuminate\Http\Request;

class DictItemController extends Controller
{

    private $service;

    public function __construct(DictItemService $service)
    {
        $this->service = $service;
    }

    public function index($dictCode, Request $request)
    {
        return DictItemInfo::collection($this->service->list($dictCode))->additional(Code::SUCCESS);
    }

    public function show($dictCode, Request $request)
    {
        return DictItemInfo::collection($this->service->getItems($dictCode))->additional(Code::SUCCESS);
    }

    public function store($dictCode, Request $request)
    {
        if ($this->service->store($dictCode, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function itemShow($dictCode, $itemId, Request $request)
    {
        return DictItemInfo::make($this->service->itemShow($dictCode, $itemId))->additional(Code::SUCCESS);
    }

    public function update($dictCode, $itemId, Request $request)
    {
        if ($this->service->update($dictCode, $itemId, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function destroy($dictCode, $itemId, Request $request)
    {
        if ($this->service->destroy($dictCode, $itemId)) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }
}
