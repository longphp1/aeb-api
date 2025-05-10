<?php

namespace App\Models;

use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;
use Illuminate\Http\Request;

class AdminLoginLog extends Model
{
    use Basis, HasValidateUnique;

    protected $table = 'ae_admin_login_logs';

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
    protected $casts = [
        'headers' => 'array',
    ];

    /**
     * 员工
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(SysUser::class, 'admin', 'id');
    }

    /**
     * @param SysUser $admin
     * @param Request $request
     */
    public static function logging(SysUser $admin, Request $request)
    {
        dispatch(function () use ($admin, $request) {
            $ip = $request->getClientIp();
            static::query()->create([
                'admin_id' => $admin->getKey(),
                'ip' => $ip,
                'ip_location' => $location??"",
                'headers' => $request->headers->all(),
                'company_id' => $admin->company_id,
            ]);
        })->afterResponse();
    }
}
