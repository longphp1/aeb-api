<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Support\Carbon;

class DictItem extends Model
{
    protected $table = 'sys_dict_item';

    protected $guarded = [];

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;


    public static function init($params, $type = 'add')
    {
        $data = [
            'label' => $params['label'],
            'value' => $params['value'],
            'tag_type' => $params['tagType'] ?? '',
            'remark' => $params['remark'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'status' => $params['status'] ?? 0,
            'company_id' => auth()->user()->company_id ?? 0,
        ];
        if ($type === 'add') {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['create_by'] = auth()->user()->id;
        } else {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $data['update_by'] = auth()->user()->id;
        }

        return $data;
    }
}
