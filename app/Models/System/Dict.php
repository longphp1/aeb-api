<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Support\Carbon;

class Dict extends Model
{

    protected $table = 'sys_dict';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(DictItem::class, 'dict_code', 'dict_code');
    }

    public function init($params, $type = 'add')
    {
        $data = [
            'dict_code' => $params['dict_code'],
            'name' => $params['name'],
            'status' => $params['status'],
            'remark' => $params['remark'],
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
