<?php

namespace App\Services\System;

use App\Models\System\Dict;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;

class DictService extends BaseService
{

    protected $model;

    protected $filterRules = [
        'name' => ['like', 'keyword'],
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
            'dict_code' => 'required|string',
            'name' => 'required|string',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
        ])->validate();
        $data = $this->model->init($params);
        return $this->query->create($data);
    }

    public function update($id,$params)
    {
        validator($params, [
            'dict_code' => 'required|string',
            'name' => 'required|string',
            'status' => 'sometimes|nullable|integer|in:0,1,2',
        ])->validate();
        $user = $this->query->findOrFail($id);
        if ($user) {
            $updateData = $this->model->init($params);
            return $user->update($updateData);
        }
        return false;
    }

    public function destroy()
    {
        $ids = Arr::wrap($this->formData['ids']);
        return $this->model->whereIn($ids)->delete();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['dict_code']) && !empty($this->formData['dict_code'])) {
            $query->where('dict_code', $this->formData['dict_code']);
        }
        if (isset($this->formData['status'])) {
            $query->where('status', $this->formData['status']);
        }
    }
}
