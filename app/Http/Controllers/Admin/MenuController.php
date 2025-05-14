<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuInfo;
use App\Lib\Code;
use App\Services\ApiResponseService;
use App\Services\System\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * 获取菜单列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        $menuList = $this->menuService->list();
        return ApiResponseService::success($menuList);
    }

    /**
     * 获取指定菜单
     *
     * @param int $id
     * @return MenuInfo
     */
    public function show($id): MenuInfo
    {
        return MenuInfo::make($this->menuService->show($id))->additional(Code::SUCCESS);
    }

    /**
     * 创建菜单
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\Illuminate\Http\Request $request)
    {

        if ($this->menuService->createMenu($request->all())) {
            return ApiResponseService::success();
        }

        return ApiResponseService::error();
    }

    /**
     * 更新菜单
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        // 调用 MenuService 的 updateMenu 方法更新菜单
        if ($this->menuService->updateMenu($id, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    /**
     * 删除菜单
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // 调用 MenuService 的 deleteMenu 方法删除菜单
        if ($this->menuService->deleteMenu($id)) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function changeStatus($id, Request $request)
    {
        if ($this->menuService->changeStatus($id, $request->all())) {
            return ApiResponseService::success();
        }
        return ApiResponseService::error();
    }

    public function optionsList(Request $request)
    {
        $menus = $this->menuService->getOptions($request->all());
        return ApiResponseService::success($menus);
    }

    public function routes(Request $request)
    {
        $routes = $this->menuService->getRoutesTree();
        return ApiResponseService::success($routes);
    }
}
