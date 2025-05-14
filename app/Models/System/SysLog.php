<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\SysUser;

class SysLog extends Model
{
    protected $table = 'sys_log';

    protected $guarded = [];

    public function createUser()
    {
        return $this->hasOne(SysUser::class, 'id', 'create_by');
    }
}
