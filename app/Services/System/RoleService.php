<?php

namespace App\Services\System;

use App\Lib\Code;
use App\Models\System\Role;
use App\Models\System\RoleMenu;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RoleService extends BaseService
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
        $this->model = new Role();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    public function index()
    {
        Log::info($this->formData);
        $this->getFilter($this->query);
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @throws ValidationException
     */
    public function store($params)
    {
        validator($params, [
            'name' => 'required|string',
            'code' => 'required|string',
            'sort' => 'sometimes|nullable|integer',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
            'dataScope' => 'sometimes|nullable|integer',
        ])->validate();
        $data = $this->model->init($params, 'add');
        $code = $this->checkRoleName($params);
        if ($code != Code::SUCCESS) {
            return $code;
        }
        $res = $this->query->create($data);
        return Code::SUCCESS;
    }

    public function update($id, $params)
    {
        validator($params, [
            'name' => 'required|string',
            'code' => 'required|string',
            'sort' => 'sometimes|nullable|integer',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
            'dataScope' => 'sometimes|nullable|integer',
        ])->validate();
        $code = $this->checkRoleName($params,'update');
        if ($code != Code::SUCCESS) {
            return $code;
        }
        $user = $this->query->findOrFail($id);
        if ($user) {
            $updateData = $this->model->init($params, 'update');
            $user->update($updateData);
            return Code::SUCCESS;
        }
        return Code::USER_NOT_EXIST;
    }

    public function checkRoleName($params, $type = 'add')
    {
        $query = Role::query();

        if ($type === 'add') {
            // 合并 name 和 code 的重复检查
            $exists = $query->where(function ($q) use ($params) {
                $q->where('name', $params['name'])
                    ->orWhere('code', $params['code']);
            })->first();

            if ($exists) {
                return $exists->name === $params['name']
                    ? Code::USER_ROLE_NAME_ALREADY_EXISTS
                    : Code::USER_ROLE_CODE_ALREADY_EXISTS;
            }
        } else {
            // 更新时同时校验 code 的唯一性
            $exists = $query->where(function ($q) use ($params) {
                $q->where('name', $params['name'])
                    ->orWhere('code', $params['code']);
            })->where('id', '!=', $params['id'])
                ->first();

            if ($exists) {
                return $exists->name === $params['name']
                    ? Code::USER_ROLE_NAME_ALREADY_EXISTS
                    : Code::USER_ROLE_CODE_ALREADY_EXISTS;
            }
        }

        return Code::SUCCESS;
    }

    public function destroy($id)
    {
        $ids = _id($id);
        return $this->model->whereIn('id', $ids)->delete();
    }


    public function changeStatus($id, $params)
    {
        validator($params, [
            'status' => 'required|integer|in:0,1,2'
        ])->validate();
        $role = $this->query->findOrFail($id);
        return $role->update(['status' => $params['status']]);
    }


    public function getFilter(&$query)
    {
        if (isset($this->formData['code']) && !empty($this->formData['code'])) {
            $query->where('code', $this->formData['code']);
        }
        if (isset($this->formData['status'])) {
            $query->where('status', $this->formData['status']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('code', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function getOptions()
    {
        $rolesList = parent::all();
        return $this->treeOption($rolesList);
    }

    public function treeOption($rolesList)
    {
        $tree = [];
        foreach ($rolesList as $role) {
            $tree[] = [
                'label' => $role['name'],
                'value' => $role['id']
            ];
        }
        return $tree;
    }

    public function getMenuIds($roleId)
    {
        return RoleMenu::query()->where('role_id', $roleId)->pluck('menu_id')->toArray();
    }

    public function storeMenus($roleId, $menuIds)
    {
        if (empty($menuIds)) {
            return false;
        }
        return DB::transaction(function () use ($roleId, $menuIds) {
            RoleMenu::query()->where('role_id', $roleId)->delete();
            $nowTime = Carbon::now()->toDateTimeString();
            $roleMenu = [];
            foreach ($menuIds as $menuId) {
                $roleMenu[] = [
                    'role_id' => $roleId,
                    'menu_id' => $menuId,
                    'company_id' => auth()->user()->company_id ?? 0,
                    'created_at' => $nowTime,
                    'updated_at' => $nowTime,
                ];
            }
            if (!empty($roleMenu)) {
                RoleMenu::query()->insert($roleMenu);
            }
            return true;
        });
    }

}
