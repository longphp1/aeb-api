<?php

namespace App\Models\System;

use App\Models\Model;

class Notice extends Model
{

    protected $table = 'sys_notice';

    protected $guarded = [];

    const TARGET_TYPE_ALL = 0;//所有
    const TARGET_TYPE_GROUP = 1;//分组

    const PUBLISHED = 1;
    const UNPUBLISHED = 0;

    public function createUser(){
        return $this->hasOne('App\Models\System\User', 'id', 'create_by');
    }
    public function updateUser(){
        return $this->hasOne('App\Models\System\User', 'id', 'update_by');
    }

}
