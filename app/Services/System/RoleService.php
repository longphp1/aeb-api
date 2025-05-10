<?php

namespace App\Services\System;

use App\Models\System\Role;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class RoleService extends BaseService
{

    protected $model;

    protected $filterRules = [
        'name' => ['like', 'keyword'],
    ];

    protected $orderBy = [
        'updated_at' => 'asc',
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
            'data_scope' => 'sometimes|nullable|integer',
        ])->validate();
        $data = $this->model->init($params);
        return $this->query->create($data);
    }

    public function update($id, $params)
    {
        validator($params, [
            'name' => 'required|string',
            'code' => 'required|string',
            'sort' => 'sometimes|nullable|integer',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
            'data_scope' => 'sometimes|nullable|integer',
        ])->validate();
        $user = $this->query->findOrFail($id);
        if ($user) {
            $updateData = $this->model->init($params);
            return $user->update($updateData);
        }
        return false;
    }

    public function destroy($id)
    {
        $ids = Arr::wrap($id);
        return $this->model->whereIn($ids)->delete();
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

}
