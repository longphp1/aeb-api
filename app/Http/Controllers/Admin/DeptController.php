<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use App\Services\System\DeptService;
use Illuminate\Http\Request;

class DeptController extends Controller
{

    private $deptService;

    public function __construct(DeptService $deptService)
    {
        $this->deptService = $deptService;
    }

    public function index()
    {
        return ApiResponseService::success($this->deptService->getList());
    }

    public function show($id)
    {
        return ApiResponseService::success($this->deptService->show($id));
    }

    public function store(Request $request)
    {
        if ($this->deptService->store($request->all())){
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function update($id,Request $request)
    {
        if ($this->deptService->update($id,$request->all())){
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function destroy($id)
    {
        if ($this->deptService->destroy($id)){
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function options()
    {
        return ApiResponseService::success($this->deptService->options());
    }
}
