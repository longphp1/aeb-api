<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\System\Dept;
use App\Models\System\Menu;
use App\Models\System\Role;
use App\Models\System\RoleMenu;
use App\Models\System\UserRole;
use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;
use App\Models\Traits\LikeScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
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
        return [];
    }

    public function roleRelation()
    {
        return $this->belongsToMany(Role::class, 'sys_user_role', 'user_id', 'role_id');
    }

    public function permRelation()
    {
        $roleIds = $this->userRole()->pluck('role_id');
        return $this->belongsToMany(Menu::class, 'sys_role_menu', 'role_id', 'menu_id')->wherePivotIn('role_id', $roleIds)->withoutGlobalScopes();
    }

    public function getRolesAttribute()
    {
        return $this->roleRelation()->pluck('code')->toArray();
    }

    public function getRolesIdsAttribute()
    {
        return $this->roleRelation()->pluck('id')->toArray();
    }

    //查询当前用户按钮权限
    public function getPermsAttribute()
    {
        return Menu::query()->join('sys_role_menu','sys_role_menu.menu_id','=','sys_menu.id')->join('sys_user_role','sys_user_role.role_id','=','sys_role_menu.role_id')->where('sys_user_role.user_id','=',$this->id)->where('type', Menu::BUTTON_TYPE)->pluck('perm')->toArray();
    }

    public function dept()
    {
        return $this->hasOne(Dept::class, 'id', 'dept_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function userRole()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }


    public static function init($params, $type = 'add')
    {
        $data = [
            'username' => $params['username'],
            'nickname' => $params['nickname'],
            'gender' => $params['gender'],
            'dept_id' => $params['deptId'],
            'avatar' => $params['avatar'] ?? '',
            'mobile' => $params['mobile'],
            'email' => $params['email'],
            'status' => $params['status'] ?? 1,
            'forbid_login' => $params['forbid_login'] ?? 0
        ];
        if ($type == 'add') {
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $data['uuid'] = Str::uuid()->toString();
            $data['create_by'] = auth()->user()->id;
            $data['company_id'] = auth()->user()->company_id;
        } else {
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $data['update_by'] = auth()->user()->id;
        }
        return $data;
    }


}
