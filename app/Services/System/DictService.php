<?php

namespace App\Services\System;

use App\Models\System\Dict;
use App\Models\System\DictItem;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;

class DictService extends BaseService
{

    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'asc',
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new Dict();
        $this->query = $this->model->newQuery();
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

    public function store($params)
    {
        validator($params, [
            'dictCode' => 'required|string',
            'name' => 'required|string',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
        ])->validate();
        $data = $this->model->init($params,'add');
        return $this->query->create($data);
    }

    public function update($id, $params)
    {
        validator($params, [
            'dictCode' => 'required|string',
            'name' => 'required|string',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
        ])->validate();
        $user = $this->query->findOrFail($id);
        if ($user) {
            $updateData = $this->model->init($params,'update');
            return $user->update($updateData);
        }
        return false;
    }

    public function destroy($id)
    {
        $ids = _id($id);
        return $this->model->whereIn($ids)->delete();
    }

    public function changeStatus($id, $params)
    {
        validator($params, [
            'status' => 'required|integer|in:0,1,2',
        ])->validate();
        $user = $this->query->findOrFail($id);
        return $user->update(['status' => $params['status']]);
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['dict_code']) && !empty($this->formData['dict_code'])) {
            $query->where('dict_code', $this->formData['dict_code']);
        }
        if (isset($this->formData['status'])) {
            $query->where('status', $this->formData['status']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('dict_code', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function getList()
    {
        $this->query->where('status', Dict::STATUS_ENABLE);
        $data = parent::all();
        $options = [];
        foreach ($data as $item) {
            $options[] = [
                'value' => $item->dict_code,
                'label' => $item->name,
            ];
        }
        return $options;
    }


}
