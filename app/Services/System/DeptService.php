<?php

namespace App\Services\System;

use App\Models\System\Dept;
use App\Services\Admin\BaseService;
use Illuminate\Support\Arr;

class DeptService extends BaseService
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
        $this->model = new Dept();
        $this->query = $this->model->newQuery();
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['parent_id'])) {
            $query->where('parent_id', $this->formData['parent_id']);
        }
        if (isset($this->formData['code'])) {
            $query->where('code', $this->formData['code']);
        }
    }

    public function getList()
    {
        $this->getFilter($this->query);
        $this->query->with(['children']);
        return parent::index();
    }


    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store()
    {
        validator($this->formData, $this->rules())->validate();
        $data = $this->model->init($this->formData);
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

    public function update($id)
    {
        validator($this->formData, $this->rules())->validate();
        $dept = $this->model->find($id);
        if ($dept) {
            $data = $this->model->init($this->formData, 'update');
            $parentIdArr = $this->getAncestorIds($data['parent_id']);
            $data['tree_path'] = implode(',', $parentIdArr);
            return $dept->update($data);
        }
        return false;
    }

    public function destroy($id)
    {
        $ids = Arr::wrap($id);
        return $this->model->whereIn($ids)->delete();
    }

    public function options()
    {
        $this->getFilter($this->query);
        $this->query->with(['children']);
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
