<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Support\Carbon;

class Config extends Model
{
    protected $table = 'sys_config';

    protected $guarded = [];

    public static function init($params, $type = 'add')
    {
        $data = [
            'config_name' => $params['configName'],
            'config_key' => $params['configKey'],
            'config_value' => $params['configValue'],
            'remark' => $params['remark'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'create_by' => auth()->user()->id,
            'company_id' => auth()->user()->company_id,
        ];
        if ($type == 'update') {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $data['update_by'] = auth()->user()->id;
        }
        return $data;
    }

}
