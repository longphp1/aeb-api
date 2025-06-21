<?php

namespace App\Services\System;

use App\Lib\Code;
use App\Models\System\CountryCode;
use App\Services\Admin\BaseService;

class CountryCodeService extends BaseService
{


    protected $model;

    protected $filterRules = [
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct(CountryCode $model)
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new CountryCode();
        $this->query = $this->model->newQuery();
    }

    public function index()
    {
        $this->getFilter($this->query);
        return parent::index();
    }

    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($params)
    {
        validator($params, [
            'name' => 'required|string',
            'code' => 'required|string',
            'emoji' => 'sometimes|nullable|string',
        ])->validate();
        $check = $this->checkCountryCode($params);
        if ($check != Code::SUCCESS) {
            return $check;
        }
        $data = $this->model::init($params);
        $this->query->create($data);
        return Code::SUCCESS;
    }

    public function update($id, $params)
    {
        validator($params, [
            'name' => 'required|string',
            'code' => 'required|string',
            'emoji' => 'sometimes|nullable|string',
        ])->validate();
        $check = $this->checkCountryCode($params, 'update');
        if ($check != Code::SUCCESS) {
            return $check;
        }
        $data = $this->model::init($params);
        $config = $this->model::find($id);
        if ($config) {
            $config->update($data);
            return Code::SUCCESS;
        }
        return Code::CONFIG_KEY_NOT_ALREADY_EXISTS;
    }

    public function checkCountryCode($params, $type = 'add')
    {

        // 构建基础查询
        $query = $this->model::query();

        // 精确匹配检查逻辑
        $codeExists = clone $query->where('code', $params['code']);
        $nameExists = clone $query->where('name', $params['name']);

        // 更新时需要排除自身
        if ($type === 'update') {
            $codeExists->where('id', '!=', $params['id']);
            $nameExists->where('id', '!=', $params['id']);
        }

        // 优先检查代码重复
        if ($codeExists->exists()) {
            return Code::COUNTRY_CODE_ALREADY_EXISTS;
        }

        // 其次检查名称重复
        if ($nameExists->exists()) {
            return Code::COUNTRY_NAME_ALREADY_EXISTS;
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
            'status' => 'required|integer|in:0,1',
        ])->validate();
        $ids = _id($id);
        $this->query->whereIn('id', $ids)->update(['status' => $params['status']]);
        return Code::SUCCESS;

    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['name'])) {
            $query->where('name', $this->formData['name']);
        }
        if (isset($this->formData['code'])) {
            $query->where('code', $this->formData['code']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('code', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function countryAll(){
        $this->getFilter($this->query);
        return parent::all();
    }
}
