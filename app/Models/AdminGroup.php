<?php

namespace App\Models;

use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminGroup extends Model
{
    use Basis, HasValidateUnique;

    protected $table = 'ae_admin_groups';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * 员工组下所有员工
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins(): HasMany
    {
        return $this->hasMany(SysUser::class, 'admin_group_id', 'id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'ae_admin_group_permissions',
            'admin_group_id',
            'permission_id'
        );
    }

    /**
     * @return bool
     */
    public function isSuperGroup()
    {
        return $this->getKey() === static::query()->first()->getKey();
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->permissions()->detach();
        });
    }
}
