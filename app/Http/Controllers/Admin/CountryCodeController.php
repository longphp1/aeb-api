<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryCodeInfo;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\CountryCodeService;
use Illuminate\Http\Request;

class CountryCodeController extends Controller
{
    private $service;

    public function __construct(CountryCodeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return CountryCodeInfo::collection($this->service->index())->additional(Code::SUCCESS);
    }

    public function show($id, Request $request)
    {
        return CountryCodeInfo::make($this->service->show($id))->additional(Code::SUCCESS);
    }

    public function store(Request $request)
    {
        $res = $this->service->store($request->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function update($id, Request $request)
    {
        $res = $this->service->update($id, $request->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function destroy($id, Request $request)
    {
        $res = $this->service->destroy($id);
        return ApiResponseService::success();
    }

    public function changeStatus($id, Request $request)
    {
        $res = $this->service->changeStatus($id, $request->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function countryAll(Request $request)
    {
        return ApiResponseService::success($this->service->countryAll());
    }
}
