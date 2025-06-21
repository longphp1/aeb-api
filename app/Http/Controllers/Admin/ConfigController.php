<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigInfo;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\ConfigService;
use Illuminate\Support\Facades\Request;

class ConfigController extends Controller
{
    private $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function index(Request $request)
    {
        return ConfigInfo::collection($this->configService->index())->additional(Code::SUCCESS);
    }

    public function store(Request $request)
    {
        $res = $this->configService->store(request()->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        } else {
            return ApiResponseService::error();
        }
    }

    public function update($id, Request $request)
    {
        $res = $this->configService->update($id, request()->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        } else {
            return ApiResponseService::error();
        }
    }

    public function destroy($id, Request $request)
    {
        if ($this->configService->destroy($id)) {
            return ApiResponseService::success();
        } else {
            return ApiResponseService::error();
        }
    }

    public function show($id, Request $request)
    {
        return ConfigInfo::make($this->configService->show($id))->additional(Code::SUCCESS);
    }

    public function refresh(Request $request)
    {
        return ApiResponseService::success($this->configService->refresh());
    }


}
