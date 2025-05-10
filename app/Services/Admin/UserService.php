<?php

namespace App\Services\Admin;

use App\Models\SysUser;
use App\Models\User;

class UserService extends BaseService
{

    protected $model;

    protected $filterRules = [
        'username,nickname,email,mobile' => ['like', 'keyword'],
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new User();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    // 修复语法错误：添加缺失的闭合大括号
    public function show(int $id)
    {
        return parent::show($id);
    }

    public function index()
    {
        $this->getFilter($this->query);
        $this->query->with(['dept','createdBy','updatedBy']);
        return parent::index();
    }

    public function store()
    {
        validator($this->formData, [
            'username' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|integer|in:0,1,2',
            'status' => 'required|integer|in:0,1,2',
            'deptId' => 'required|integer',
            'roleIds' => 'sometimes|nullable|array',
            'mobile' => 'sometimes|nullable|string',
            'email' => 'required|email',
            'is_audited' => 'sometimes|integer',
            'forbid_login' => 'sometimes|integer',
            'avatar' => 'sometimes|string',
            'openId' => 'sometimes|string',
        ])->validate();
        $data = $this->model->init($this->formData);
        return $this->query->create($data);
    }

    public function update(int $id)
    {
        validator($this->formData, [
            'username' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|integer|in:0,1,2',
            'status' => 'required|integer|in:0,1,2',
            'deptId' => 'required|integer',
            'roleIds' => 'sometimes|nullable|array',
            'mobile' => 'sometimes|nullable|string',
            'email' => 'required|email',
            'is_audited' => 'sometimes|integer',
            'forbid_login' => 'sometimes|integer',
            'avatar' => 'sometimes|string',
            'openId' => 'sometimes|string',
        ])->validate();

        $user = $this->query->findOrFail($id);
        if ($user) {
            $updateData = $this->model->init($this->formData);
            return $user->update($updateData);
        }
        return false;
    }

    public function destroy(int $id)
    {
        $user = $this->query->findOrFail($id);
        return $user->delete();
    }

    public function enable(int $id)
    {
        return $this->setStatus($id, 1);
    }

    public function disable(int $id)
    {
        return $this->setStatus($id, 0);
    }

    private function setStatus(int $id, int $status)
    {
        $user = $this->query->findOrFail($id);
        return $user->update(['status' => $status]);
    }

    public function getFilter(&$query)
    {
        if (isset($this->formData['nickname']) && !empty($this->formData['nickname'])) {
            $query->where('nickname', trim($this->formData['nickname']));
        }
    }
}
