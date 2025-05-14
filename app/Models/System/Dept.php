<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\SysUser;
use Illuminate\Support\Carbon;

class Dept extends Model
{

    protected $table = 'sys_dept';

    protected $guarded = [];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function createUser()
    {
        return $this->hasOne(SysUser::class, 'user_id', 'create_by');
    }

    public function updateUser()
    {
        return $this->hasOne(SysUser::class, 'user_id', 'update_by');
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('sort');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // 递归获取所有后代（包含嵌套子级）
    public function children()
    {
        return $this->child()->with('children');
    }

    public function init($params, $type = 'add')
    {
        $data = [
            'name' => $params['name'],
            'code' => $params['code'],
            'parent_id' => $params['parentId'],
            'sort' => $params['sort'],
            'status' => $params['status'],
            'create_by' => auth()->user()->id,
            'company_id' => auth()->user()->company_id ?? 0,
            'created_at' => Carbon::now()->toDateTimeString(),
        ];
        if ($type == 'update') {
            $data['update_by'] = auth()->user()->id;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }
}
