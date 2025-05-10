<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleList;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return RoleList::make($this->roleService->index())->additional(Code::SUCCESS);
    }

    public function show($id)
    {
        return RoleList::make($this->roleService->show($id))->additional(Code::SUCCESS);
    }

    public function store(Request $request)
    {
        try {
            $user = $this->roleService->store($request->all());
            return ApiResponseService::success($user);
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }


    public function update($id, Request $request)
    {
        try {
            $user = $this->roleService->update($id,$request->all());
            return ApiResponseService::success($user);
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->destroy($id);
            return ApiResponseService::success();
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    public function changeStatus($id, Request $request)
    {
        try {
            $this->roleService->changeStatus($id, $request->all());
            return ApiResponseService::success();
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    public function optionsList(Request $request){
        $menus = $this->roleService->getOptions();
        return ApiResponseService::success($menus);
    }

}
