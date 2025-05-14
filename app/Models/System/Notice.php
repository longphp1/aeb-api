<?php

namespace App\Models\System;

use App\Models\Model;
use App\Models\SysUser;
use Illuminate\Support\Carbon;

class Notice extends Model
{

    protected $table = 'sys_notice';

    protected $guarded = [];

    const TARGET_TYPE_ALL = 0;//所有
    const TARGET_TYPE_GROUP = 1;//分组

    const PUBLISHED = 1;
    const UNPUBLISHED = 0;

    const REVOKED = -1;

    public function createUser()
    {
        return $this->hasOne(SysUser::class, 'id', 'create_by');
    }

    public function updateUser()
    {
        return $this->hasOne(SysUser::class, 'id', 'update_by');
    }

    public function publisher()
    {
        return $this->hasOne(SysUser::class, 'id', 'publisher_id');
    }

    public static function init($params, $type = '')
    {
        $data = [
            'title' => $params['title'],
            'content' => $params['content'],
            'type' => $params['type'],
            'level' => $params['level'],
            'target_type' => $params['targetType'],

            'publisher_id' => auth()->user()->id,
            'publish_status' => self::UNPUBLISHED,
            'create_by' => auth()->user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'company_id' => auth()->user()->company_id,
        ];
        if ($type == 'update') {
            $data['update_by'] = auth()->user()->id;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }

}
