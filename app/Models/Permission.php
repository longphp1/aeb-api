<?php

namespace App\Models;

use App\Models\Traits\Basis;
use App\Models\Traits\CustomHasTranslations;
use App\Models\Traits\HasValidateUnique;

class Permission extends Model
{
    use Basis, CustomHasTranslations, HasValidateUnique;

    public $translatable = ['name'];

    protected $table = 'permissions';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [];

    /**
     * 权限组
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(PermissionGroup::class, 'group_id', 'id');
    }

    /**
     * 是否全都存在
     * @param array $permission
     * @return bool
     */
    public static function isValid(array $permission): bool
    {
        return self::whereIn('id', $permission)->count() === count(array_unique($permission));
    }
}
