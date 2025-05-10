<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\SysUser;

class UserNotice extends Model
{

    protected $table = 'sys_user_notice';

    protected $guarded = [];

    const READ = 1;
    const UNREAD = 0;

    public function notice(){
        return $this->belongsTo(Notice::class,'notice_id','id');
    }

    public function user(){
        return $this->hasOne(SysUser::class,'user_id','id');
    }
}
