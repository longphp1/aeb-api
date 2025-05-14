<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\User;
use Carbon\Carbon;

class Role extends Model
{
    protected $table = 'sys_role';

    protected $guarded = [];

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public function init($params, $type = 'add')
    {
        $data = [
            'name' => $params['name'],
            'code' => $params['code'] ?? '',
            'sort' => $params['sort'] ?? '',
            'status' => $params['status'] ?? '',
            'data_scope' => $params['dataScope'] ?? 0,
        ];
        if ($type == 'add') {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['create_by'] = auth()->user()->id ?? 0;
            $data['company_id'] = auth()->user()->company_id ?? 0;
        } else {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $data['update_by'] = auth()->user()->id ?? 0;
        }
        return $data;
    }

    public function createBy()
    {
        return $this->hasOne(User::class, 'id', 'create_by');
    }

    public function updateBy()
    {
        return $this->hasOne(User::class, 'id', 'update_by');
    }
}
