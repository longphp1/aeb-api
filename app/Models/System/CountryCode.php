<?php

namespace App\Models\System;

use App\Models\Model;
use Illuminate\Support\Carbon;

class CountryCode extends Model
{
    protected $table = 'sys_country_code';

    protected $guarded = [];

    public static function init($params, $type = 'add')
    {
        $data = [
            'name' => $params['name'],
            'code' => $params['code'],
            'emoji' => $params['emoji'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'company_id' => auth()->user()->company_id,
        ];
        if ($type == 'update') {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }

    public  function getStatusNameAttribute(){
        switch ($this->status) {
            case 1:
                return '启用';
            case 0:
                return '停用';
        }
    }

}
