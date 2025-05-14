<?php

namespace App\Services\System;

use App\Lib\Code;
use App\Models\System\Config;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class ConfigService extends BaseService
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
        $this->model = new Config();
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
            'configName' => 'required|string',
            'configKey' => 'required|string',
            'configValue' => 'required|string',
        ])->validate();
        $check = $this->checkConfigKey($params['configKey']);
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
            'configName' => 'required|string',
            'configKey' => 'required|string',
            'configValue' => 'required|string',
        ])->validate();
        $check = $this->checkConfigKey($params['configKey'],$id);
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

    public function checkConfigKey($configKey,$id=0)
    {
        $config = $this->model::where('config_key', $configKey)->first();
        if ($config && $config->id != $id) {
            return Code::CONFIG_KEY_ALREADY_EXISTS;
        }
        return Code::SUCCESS;
    }

    public function destroy($id)
    {
        $ids = _id($id);
        return $this->model->whereIn($ids)->delete();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['config_name'])) {
            $query->where('config_name', $this->formData['config_name']);
        }
        if (isset($this->formData['config_key'])) {
            $query->where('config_key', $this->formData['config_key']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('config_name', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('config_key', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function refresh()
    {
        $configs = $this->model->all();
        foreach ($configs as $config) {
            $key = $config->config_key;
            $value = $config->config_value;
            Redis::set($key, $value);
        }
    }
}
