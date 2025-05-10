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

    public  function init($params, $type = 'add')
    {
        $data = [
            'parent_id' => $params['parent_id'],
            'tree_path' => $params['tree_path'] ?? '',
            'name' => $params['name'] ?? '',
            'type' => $params['type'] ?? '',
            'route_name' => $params['route_name'] ?? '',
            'route_path' => $params['route_path'] ?? '',
            'component' => $params['component'] ?? '',
            'perm' => $params['perm'],
            'always_show' => $params['always_show'] ?? '',
            'keep_alive' => $params['keep_alive'] ?? '',
            'visible' => $params['visible'] ?? '',
            'sort' => $params['sort'] ?? '',
            'icon' => $params['icon'] ?? '',
            'redirect' => $params['redirect'] ?? '',
            'params' => $params['params'] ?? '',
            'created_at' => Carbon::now()->toDateTimeString(),
            'company_id' => auth()->user()->company_id ?? '',
        ];
        if ($type == 'update') {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
        }
        return $data;
    }
}
