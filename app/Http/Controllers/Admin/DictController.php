<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return $this->dictService->index();
    }

    public function show($id,Request $request)
    {
        return $this->dictService->show($id);
    }

    public function store($id,Request $request)
    {
        if ($this->dictService->store($id,$request->all())){
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function update($id,Request $request)
    {
        if ($this->dictService->update($id,$request->all())){
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function destroy($id)
    {
        if ($this->dictService->delete($id)){
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function getDictItems()
    {

    }

    public function optionsList()
    {

    }
}
