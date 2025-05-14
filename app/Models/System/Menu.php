<?php

namespace App\Models\System;

use App\Models\Model;
use Carbon\Carbon;

class Menu extends Model
{

    protected $table = 'sys_menu';

    protected $guarded = [];

    const MENU_TYPE = 1;
    const CATALOG_TYPE = 2;
    const LINK_TYPE = 3;
    const BUTTON_TYPE = 4;


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function init($params, $type = 'add')
    {
        $data = [
            'parent_id' => $params['parentId'],
            'name' => $params['name'] ?? '',
            'type' => $params['type'] ?? '',
            'route_name' => $params['routeName'] ?? '',
            'route_path' => $params['routePath'] ?? '',
            'component' => $params['component'] ?? '',
            'perm' => $params['perm']??'',
            'always_show' => $params['alwaysShow'] ?? 0,
            'keep_alive' => $params['keepAlive'] ?? 0,
            'visible' => $params['visible'] ?? 1,
            'sort' => $params['sort'] ?? 1,
            'icon' => $params['icon'] ?? '',
            'redirect' => $params['redirect'] ?? '',
            'params' => isset($params['params']) ? json_encode($params['params']) : '',
            'created_at' => Carbon::now()->toDateTimeString(),
            'company_id' => auth()->user()->company_id ??0,
        ];
        if ($type == 'update') {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }
}
