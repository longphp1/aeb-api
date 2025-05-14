<?php

namespace App\Services\System;

use App\Models\System\Dept;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;

class DeptService extends BaseService
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
        $this->model = new Dept();
        $this->query = $this->model->newQuery();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['parentId'])) {
            $query->where('parent_id', $this->formData['parentId']);
        }
        if (isset($this->formData['code'])) {
            $query->where('code', $this->formData['code']);
        }
        if (isset($this->formData['status'])) {
            $query->where('status', $this->formData['status']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('code', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('name', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function getList()
    {
        $this->getFilter($this->query);
        $this->query->with(['children'])->where('parent_id',0);
        return parent::all();
    }


    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($params)
    {
        validator($params, $this->rules())->validate();
        $data = $this->model->init($params);
        $parentIdArr = $this->getAncestorIds($data['parent_id']);
        $data['tree_path'] = implode(',', $parentIdArr);
        return $this->query->create($data);
    }

    public function getAncestorIds(int $deptId): array
    {
        $ids = [$deptId];
        $currentDept = Dept::find($deptId);

        while ($currentDept && $currentDept->parent_id != 0) {
            $parentDept = Dept::find($currentDept->parent_id);
            if (!$parentDept) break;

            $ids[] = $parentDept->id;
            $currentDept = $parentDept;
        }

        return array_reverse($ids); // 按层级顺序返回 [上级, 上上级...]
    }

    public function update($id,$params)
    {
        validator($params, $this->rules())->validate();
        $dept = $this->model->find($id);
        if ($dept) {
            $data = $this->model->init($params, 'update');
            $parentIdArr = $this->getAncestorIds($data['parent_id']);
            $data['tree_path'] = implode(',', $parentIdArr);
            return $dept->update($data);
        }
        return false;
    }

    public function destroy($id)
    {
        $ids = _id($id);
        return $this->model->whereIn($ids)->delete();
    }

    public function options()
    {
        $this->getFilter($this->query);
        $this->query->with(['children'])->where('parent_id',0);
        $deptList = parent::all();
        return $this->treeOptions($deptList);
    }

    public function treeOptions($deptList)
    {
        $treeOptions = [];
        foreach ($deptList as $dept) {
            $treeOptions[] = [
                'value' => $dept->id,
                'label' => $dept->name,
                'children' => $this->treeOptions($dept->children),
            ];
        }
        return $treeOptions;
    }

    public function rules()
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'parentId' => 'required|integer',
            'sort' => 'required|integer',
            'status' => 'required|integer',
        ];
    }
}
