<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\SysUser;

class UserRole extends Model
{

    protected $table = 'sys_user_role';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(SysUser::class, 'sys_user_role', 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'sys_user_role', 'role_id', 'id');
    }
}
