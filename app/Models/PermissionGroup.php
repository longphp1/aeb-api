<?php

namespace App\Models;

use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;

class PermissionGroup extends Model
{
    use Basis, HasValidateUnique;

    protected $table = 'ae_permission_group';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [];

    /**
     * 权限
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }


    /**
     * 权限
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buttonGroups()
    {
        return $this->hasMany(PermissionGroup::class, 'parent_menu_id', 'menu_id');
    }

    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id', 'id');
    }
}
