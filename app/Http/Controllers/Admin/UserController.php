<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserInfo;
use App\Http\Resources\UserList;
use App\Lib\Code;
use App\Services\Admin\UserService;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 获取用户列表
     */
    public function index()
    {
        return UserList::make($this->userService->index())->additional(Code::SUCCESS);
    }

    /**
     * 创建新用户
     */
    public function store(Request $request)
    {
        try {
            $user = $this->userService->store($request->all());
            if ($user == Code::SUCCESS) {
                return ApiResponseService::success($user);
            }
            return ApiResponseService::error($user);
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    /**
     * 显示单个用户详情
     */
    public function show($id)
    {
        return UserInfo::make($this->userService->show($id))->additional(Code::SUCCESS);
    }

    /**
     * 更新用户信息
     */
    public function update($id, Request $request)
    {
        try {
            $user = $this->userService->update($id, $request->all());
            if ($user == Code::SUCCESS) {
                return ApiResponseService::success($user);
            }
            return ApiResponseService::error($user);
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    /**
     * 删除用户
     */
    public function destroy($id)
    {
        try {
            $this->userService->destroy($id);
            return ApiResponseService::success();
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    /**
     * 启用用户
     */
    public function enable($id)
    {
        try {
            $this->userService->enable($id);
            return ApiResponseService::success();
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }

    /**
     * 禁用用户
     */
    public function disable($id)
    {
        try {
            $this->userService->disable($id);
            return ApiResponseService::success();
        } catch (\Exception $e) {
            return ApiResponseService::errorMessage($e->getMessage());
        }
    }


    /**
     * Get the authenticated User.
     *
     * @return UserInfo
     */
    public function me()
    {
        return UserInfo::make(auth()->user())->additional(Code::SUCCESS);
    }

    /**
     * 导出用户信息
     */
    public function export(Request $request)
    {
        return $this->userService->export($request->all());
    }

    public function template(Request $request)
    {
        $file = Storage::disk('tmp')->get("userImportTemplate.xlsx");
        return response()->streamDownload(function () use ($file) {
            echo $file;
        }, "userImportTemplate");
    }

    public function import(Request $request)
    {
        if ($res = $this->userService->import($request->all())) {
            return ApiResponseService::success($res);
        }
        return ApiResponseService::errorMessage("导入失败");
    }

    public function resetPassword($id, Request $request)
    {
        return ApiResponseService::success($this->userService->resetPassword($id, $request->all()));
    }

    public function changeStatus($id, Request $request)
    {
        if ($res = $this->userService->changeStatus($id, $request->all())) {
            return ApiResponseService::success($res);
        }
        return ApiResponseService::errorMessage("修改失败");
    }

    public function updateProfile(Request $request)
    {
        if ($res = $this->userService->updateProfile($request->all())) {
            return ApiResponseService::success($res);
        }
        return ApiResponseService::errorMessage("修改失败");
    }

    public function updatePassword(Request $request)
    {
        if ($res = $this->userService->updatePassword($request->all())) {
            return ApiResponseService::success($res);
        }
        return ApiResponseService::errorMessage("修改失败");
    }

    public function optionsList(Request $request)
    {
        return ApiResponseService::success($this->userService->optionsList($request->all()));
    }
}
