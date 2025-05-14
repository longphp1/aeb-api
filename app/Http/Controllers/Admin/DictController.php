<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DictInfo;
use App\Http\Resources\DictItemInfo;
use App\Http\Resources\DictList;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\DictService;
use Illuminate\Http\Request;

class DictController extends Controller
{
    private $dictService;

    public function __construct(DictService $dictService)
    {
        $this->dictService = $dictService;
    }

    public function index()
    {
        return DictList::make($this->dictService->index())->additional(Code::SUCCESS);
    }

    public function show($id, Request $request)
    {
        return DictInfo::make($this->dictService->show($id))->additional(Code::SUCCESS);
    }

    public function store(Request $request)
    {
        if ($res = $this->dictService->store($request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function update($id, Request $request)
    {
        if ($this->dictService->update($id, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function destroy($ids)
    {
        if ($this->dictService->destroy($ids)) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function changeStatus($id, Request $request)
    {
        if ($this->dictService->changeStatus($id, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function optionsList(Request $request)
    {
        if ($res = $this->dictService->getList($request->all())) {
            return ApiResponseService::success($res);
        }
        return ApiResponseService::error();
    }


}
