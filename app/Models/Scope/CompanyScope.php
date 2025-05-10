<?php

namespace App\Models\Scope;

use App\Models\SysUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cache;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder  $builder
     * @param  Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();



        //如果是管理员端
        if ($user instanceof SysUser) {
            $builder->whereRaw($model->getTable() . '.company_id = ' . $user->company_id);
        }

        //如果是客户端
        if ($user instanceof User) {
            $builder->whereRaw($model->getTable() . '.company_id = ' . $user->company_id);
            return;
        }

        //如果是未认证状态
        if (auth()->guest()) {

            $id = 2;
            // if (!($id = static::getUuidFromHeader())) {

            //     $id = static::getUuidFromInput();
            // }

            if ($id) {
                $builder->whereRaw($model->getTable() . '.company_id = ' . $id);
            } else {
                // 客户端的UUID错误的或者没传的数据为空
                if (str_starts_with(request()->path(), 'api/client')) {
                    $builder->whereRaw($model->getTable() . '.company_id = -1');
                }

            }
        }
    }

    /**
     * @return int|null
     */
    public static function getUuidFromHeader(): ?int
    {
        if (request()->hasHeader('X-Uuid')) {
            $uuid = request()->header('X-Uuid');

            if (! $uuid) {
                return null;
            }

            return Cache::get($uuid, function () use ($uuid) {
                $admin = SysUser::where('uuid', $uuid)->withoutGlobalScope(CompanyScope::class)->first();

                if ($admin) {
                    $id = $admin->id;
                } else {
                    $id = 0;
                }

                Cache::forever($uuid, $id);

                return $id;
            });
        }

        return null;
    }

    /**
     * @return int|null
     */
    public static function getUuidFromInput(): ?int
    {
        if (request()->has('X-Uuid')) {
            $uuid = request()->input('X-Uuid');

            return Cache::get($uuid, function () use ($uuid) {
                $id = SysUser::where('uuid', $uuid)->withoutGlobalScope(CompanyScope::class)->firstOrFail()->id;

                Cache::forever($uuid, $id);

                return $id;
            });
        }

        return null;
    }
}
