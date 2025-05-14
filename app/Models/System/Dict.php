<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Support\Carbon;

class Dict extends Model
{

    protected $table = 'sys_dict';

    protected $guarded = [];

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public function items()
    {
        return $this->hasMany(DictItem::class, 'dict_code', 'dict_code');
    }

    public function init($params, $type = 'add')
    {
        $data = [
            'dict_code' => $params['dictCode'],
            'name' => $params['name'],
            'status' => $params['status'],
            'remark' => $params['remark'],
            'company_id' => auth()->user()->company_id ?? 0,
        ];
        if ($type == 'add') {
            $data['create_by'] = auth()->user()->id;
            $data['created_at'] = Carbon::now()->toDateTimeString();
        } else {
            $data['update_by'] = auth()->user()->id;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }
}
