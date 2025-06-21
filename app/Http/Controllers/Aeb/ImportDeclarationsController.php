<?php

namespace App\Http\Controllers\Aeb;

use App\Http\Controllers\Controller;
use App\Http\Resources\Aeb\ImportDeclarationsInfo;
use App\Lib\Code;
use App\Services\Aeb\Import\ImportDeclarationsService;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Request;

class ImportDeclarationsController extends Controller
{

    private $service;

    public function __construct(ImportDeclarationsService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return ImportDeclarationsInfo::collection($this->service->index())->additional(Code::SUCCESS);
    }

    public function store(Request $request)
    {
        $res = $this->service->store(request()->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        } else {
            return ApiResponseService::error();
        }
    }

    public function update($id, Request $request)
    {
        $res = $this->service->update($id, request()->all());
        if ($res == Code::SUCCESS) {
            return ApiResponseService::success();
        } else {
            return ApiResponseService::error();
        }
    }

    public function destroy($id, Request $request)
    {
        if ($this->service->destroy($id)) {
            return ApiResponseService::success();
        } else {
            return ApiResponseService::error();
        }
    }

    public function show($id, Request $request)
    {
        return ImportDeclarationsInfo::make($this->service->show($id))->additional(Code::SUCCESS);
    }

    public function importDeclarationsEnum(Request $request)
    {
        return ApiResponseService::success($this->service->getImportDeclarationsEnum());
    }
}
