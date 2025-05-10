<?php

namespace App\Models;

use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;

class MenuGroup extends Model
{
    use Basis, HasValidateUnique;

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected $table = 'ae_menu_group';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [];

    public function permissionGroups()
    {
        return $this->hasMany(PermissionGroup::class, 'menu_group_id', 'id');
    }

    public function getMenuNameAttribute()
    {
        return $this->name;
    }
}
