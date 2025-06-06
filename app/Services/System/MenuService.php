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
        $this->query->with(['children'])->where('type', Menu::CATALOG_TYPE)->orderBy('sort', 'asc');
        $menusList = parent::all();
        return $this->getRoutesTreeMenu($menusList);
    }

    public function getRoutesTreeMenu($menusList)
    {
        $tree = [];
        foreach ($menusList as $menu) {
            $firstMenu = [
                'name' => $menu->route_path,
                'path' => $menu->route_path,
                'redirect' => $menu->redirect,
                'component' => $menu->component,
                'meta' => [
                    'title' => $menu->name,
                    'icon' => $menu->icon,
                    'alwaysShow' => $menu->always_show == 1 ? true : false,
                    'hidden' => $menu->visible == 1 ? false : true,
                ],
                'children' => [],
            ];
            foreach ($menu->children as $child) {
                $secondMenu = [
                    'name' => $child->name,
                    'path' => $child->route_path,
                    'redirect' => $child->redirect,
                    'component' => $child->component,
                    'meta' => [
                        'title' => $child->name,
                        'path' => $child->route_path,
                        'icon' => $child->icon,
                        'alwaysShow' => $child->always_show == 1 ? true : false,
                        'hidden' => $child->visible == 1 ? false : true,
                        'params' => $child->params
                    ],
                    'children' => [],
                ];
                $childList = Menu::query()->where('parent_id', $child->id)->where('type', Menu::MENU_TYPE)->get();
                foreach ($childList as $tmp) {
                    $thirdMenu = [
                        'name' => $tmp->name,
                        'path' => $tmp->route_path,
                        'redirect' => $tmp->redirect,
                        'component' => $tmp->component,
                        'meta' => [
                            'title' => $tmp->name,
                            'path' => $child->route_path,
                            'icon' => $tmp->icon,
                            'alwaysShow' => $tmp->always_show == 1 ? true : false,
                            'hidden' => $tmp->visible == 1 ? false : true,
                        ],
                        'children' => [],
                    ];
                    $secondMenu['children'][] = $thirdMenu;
                }
                $firstMenu['children'][] = $secondMenu;
            }
            $tree[] = $firstMenu;
        }
        return $tree;
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
