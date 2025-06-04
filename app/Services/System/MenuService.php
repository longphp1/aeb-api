<?php

namespace App\Services\System;

use App\Models\System\Menu;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;

class MenuService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new Menu();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    /**
     * 获取菜单列表
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilter(&$query)
    {
        if (isset($this->formData['name']) && !empty($this->formData['name'])) {
            $query->where('nickname', trim($this->formData['nickname']));
        }
        if (isset($this->formData['type']) && !empty($this->formData['type'])) {
            $query->where('type', trim($this->formData['type']));
        }
        if (isset($this->formData['route_name']) && !empty($this->formData['route_name'])) {
            $query->where('route_name', trim($this->formData['route_name']));
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('route_name', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function show($id)
    {
        $this->getFilter($this->query);
        return $this->query->with(['children'])->findOrFail($id);
    }

    /**
     * 获取菜单树形结构
     *
     * @return array
     */
    public function list()
    {
        $this->getFilter($this->query);
        $this->query->with(['children'])->where('type', Menu::CATALOG_TYPE);
        $menusList = parent::index();
        return $this->buildTree($menusList);
    }

    /**
     * 构建菜单树形结构
     *
     * @param \Illuminate\Database\Eloquent\Collection $menus
     * @param int $parentId
     * @return array
     */
    public function buildTree($menusList, $pid = 0)
    {
        $tree = [];
        foreach ($menusList as $menu) {
            foreach ($menu->children as $child) {
                $child->children = Menu::where('parent_id', $child->id)->get();
            }
            $tree[] = $menu;
        }
        return $tree;
    }

    /**
     * 新增菜单
     *
     * @param array $data
     * @return \App\Models\System\Menu
     */
    public function createMenu(array $data)
    {
        validator($this->formData, $this->rules())->validate();

        $data = $this->model->init($this->formData);
        return $this->query->create($data);
    }

    /**
     * 修改菜单
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateMenu($id, array $data)
    {
        validator($this->formData, $this->rules())->validate();
        $menu = $this->model->find($id);
        if ($menu) {
            $data = $this->model->init($this->formData, 'update');
            return $menu->update($data);
        }
        return false;
    }

    /**
     * 删除菜单
     *
     * @param int $id
     * @return bool
     */
    public function deleteMenu($id)
    {
        $ids = _id($id);
        return $this->query->whereIn('id',$ids)->delete();
    }

    /**
     * 递归删除子菜单
     *
     * @param int $parentId
     */
    private function deleteChildMenus($parentId)
    {
        $children = $this->model->where('parent_id', $parentId)->get();
        foreach ($children as $child) {
            $this->deleteChildMenus($child->id);
            $child->delete();
        }
    }

    /**
     * 禁用菜单
     *
     * @param int $id
     * @return bool
     */
    public function changeStatus($id, $params)
    {
        $menu = $this->model->find($id);
        if ($menu) {
            return $menu->update(['visible' => $params['visible']]);
        }
        return false;
    }

    public function getOptions($params)
    {
        $this->query->with(['children'])->where('type', Menu::CATALOG_TYPE)->orderBy('sort', 'asc');
        $menusList = parent::all();
        return $this->treeOption($menusList, $params['onlyParent']??false);
    }

    public function treeOption($menusList, $onlyParent = false)
    {
        $tree = [];
        foreach ($menusList as $menu) {
            $firstTmp = [
                'value' => $menu->id,
                'label' => $menu->name,
                'children' => [],
            ];
            foreach ($menu->children as $child) {
                $secondTmp = [
                    'value' => $child->id,
                    'label' => $child->name,
                    'children' => [],
                ];
                if (!$onlyParent) {
                    $childList = Menu::query()->where('parent_id', $child->id)->get();
                    foreach ($childList as $tmp) {
                        $thirdTmp = [
                            'value' => $tmp->id,
                            'label' => $tmp->name,
                            'children' => [],
                        ];
                        $secondTmp['children'][] = $thirdTmp;
                    }
                }
                $firstTmp['children'][] = $secondTmp;
            }
            $tree[] = $firstTmp;
        }
        return $tree;
    }

    public function getRoutesTree()
    {
        $menuIds = getUserMenuId();
        $this->query->with(['children'])->where('type', Menu::CATALOG_TYPE)->orderBy('sort', 'asc');
        if ($menuIds) {
            $this->query->whereIn('id', $menuIds);
        }
        $menusList = parent::all();
        return $this->getRoutesTreeMenu($menusList,$menuIds);
    }

    public function getRoutesTreeMenu($menusList,$menuIds)
    {
        $tree = [];
        foreach ($menusList as $menu) {
            if(!in_array($menu->id,$menuIds)){
                continue;
            }
            $firstMenu = $this->buildMenuItem($menu);

            foreach ($menu->children as $child) {
                if(!in_array($child->id,$menuIds)){
                    continue;
                }
                $secondMenu = $this->buildMenuItem($child);

                // 预加载第三级菜单避免 N+1 查询
                $child->load(['children' => function($query) {
                    $query->where('type', Menu::MENU_TYPE);
                }]);

                foreach ($child->children as $tmp) {
                    if(!in_array($tmp->id,$menuIds)){
                        continue;
                    }
                    $thirdMenu = $this->buildMenuItem($tmp);
                    $secondMenu['children'][] = $thirdMenu;
                }

                $firstMenu['children'][] = $secondMenu;
            }
            $tree[] = $firstMenu;
        }
        return $tree;
    }

    /**
     * 构建统一菜单项结构
     */
    private function buildMenuItem(Menu $menu): array
    {
        return [
            'name' => $menu->name,
            'name_en' => $menu->name_en,
            'path' => $menu->route_path,
            'redirect' => $menu->redirect,
            'component' => $menu->component,
            'meta' => [
                'title' => $menu->name,
                'title_en' => $menu->name_en,
                'path' => $menu->route_path, // 修复原第三级菜单 path 错误
                'icon' => $menu->icon,
                'alwaysShow' => (bool)$menu->always_show,
                'hidden' => !(bool)$menu->visible,
                'params' => $menu->params ?? null
            ],
            'children' => [],
        ];
    }
    public function rules()
    {
        return [
            'parentId' => 'required|integer',
            'name' => 'required|string',
            'type' => 'required|integer|in:1,2,3,4',
            'routeName' => 'sometimes|nullable|string',
            'routePath' => 'sometimes|nullable|string',
            'component' => 'sometimes|nullable|string',
            'perm' => 'sometimes|nullable|string',
            'alwaysShow' => 'sometimes|nullable|integer|in:0,1',
            'keepAlive' => 'sometimes|nullable|integer|in:0,1',
            'visible' => 'sometimes|nullable|integer|in:0,1',
            'sort' => 'sometimes|nullable|integer',
            'icon' => 'sometimes|nullable|string',
            'redirect' => 'sometimes|nullable|string',
            'params' => 'sometimes|nullable|array',
        ];
    }

}
