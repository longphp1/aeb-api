<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserInfo;
use App\Http\Resources\UserList;
use App\Lib\Code;
use App\Services\Admin\UserService;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

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
            return ApiResponseService::success($user);
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
    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->update($id);
            return ApiResponseService::success($user);
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
            $this->userService->delete($id);
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
}
