<?php

namespace App\Services\System;

use App\Models\System\Dict;
use App\Models\System\DictItem;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;

class DictItemService extends BaseService
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
        $this->model = new DictItem();
        $this->query = $this->model->newQuery();
    }

    public function list($dictCode)
    {
        $this->getFilter($this->query);
        $this->query->where('dict_code', $dictCode);
        return parent::index();
    }

    public function getItems($dictCode)
    {
        $data = $this->query->where('dict_code', $dictCode)->where('status', DictItem::STATUS_ENABLE)->get();
        return $data;
    }

    public function store($dictCode, $params)
    {
        validator($params, [
            'value' => 'required|string',
            'label' => 'required|string',
            'tagType' => 'required|string',
            'sort' => 'sometimes|nullable|integer',
            'remark' => 'sometimes|nullable|string',
        ])->validate();
        $data = $this->model::init($params, 'add');
        $data['dict_code'] = $dictCode;
        $dictItem = $this->query->where('dict_code', $dictCode)->where('value', $params['value'])->where('label', $params['label'])->first();
        if ($dictItem) {
            return false;
        }
        return $this->query->create($data);
    }

    public function itemShow($dictCode, $id)
    {
        return DictItem::query()->where('dict_code', $dictCode)->where('id', $id)->first();
    }

    public function update($dictCode, $id, $params)
    {
        validator($params, [
            'value' => 'required|string',
            'label' => 'required|string',
            'tagType' => 'required|string',
            'sort' => 'sometimes|nullable|integer',
            'remark' => 'sometimes|nullable|string',
        ])->validate();
        $data = $this->model::init($params, 'update');
        $data['dict_code'] = $dictCode;
        $dictItem = $this->query->where('id', $id)->first();
        if ($dictItem) {
            $dictItem->update($data);
            return $dictItem;
        }
        return false;
    }

    public function destroy($dictCode, $id)
    {
        $ids = _id($id);
        return $this->query->where('dict_code', $dictCode)->whereIn('id', $ids)->delete();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['label'])) {
            $query->where('label', $this->formData['label']);
        }
        if (isset($this->formData['tag_type'])) {
            $query->where('tag_type', $this->formData['tag_type']);
        }
        if (isset($this->formData['dict_code'])) {
            $query->where('dict_code', $this->formData['dict_code']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('label', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('value', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }
}
