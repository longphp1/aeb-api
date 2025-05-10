<?php

namespace App\Models;

use App\Models\System\Role;
use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;
use App\Models\Traits\LikeScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class SysUser extends Authenticatable implements JWTSubject
{
    use Basis,
        HasValidateUnique,
        LikeScope;

    protected $table = 'sys_user';

    protected $guarded = [];

    const STATUS_ENABLE = 1;

    const STATUS_DISABLE = 0;

    const SEX_MAN = 1;
    const SEX_WOMAN = 2;
    const SEX_UNKNOWN = 0;

    public static $statusList = [
        self::STATUS_DISABLE => '禁用',
        self::STATUS_ENABLE => '启用',
    ];

    public static $sexList = [
        self::SEX_MAN => '男',
        self::SEX_WOMAN => '女',
        self::SEX_UNKNOWN => '保密'
    ];
    protected $fillable = [
        'username',
        'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'forbid_login' => 'bool',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => 'admin',
        ];
    }


    public function init($params, $type = 'add')
    {

        $data = [
            'username' => $params['username'],
            'nickname' => $params['nickname'] ?? '',
            'gender' => $params['gender'] ?? '',
            'dept_id' => $params['dept_id'] ?? '',
            'avatar' => $params['avatar'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'status' => $params['status'] ?? '',
            'email' => $params['email'],
            'remember_token' => $params['remember_token'] ?? '',
            'uuid' => $params['uuid'] ?? '',
            'created_at' => Carbon::now()->toDateTimeString(),
            'create_by' => auth()->user()->id ?? '',
            'company_id' => auth()->user()->company_id ?? '',
        ];
        if ($type == 'update') {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $data['update_by'] = auth()->user()->id ?? '';
        }
        return $data;
    }



}
