<?php



namespace App\Models;

use App\Models\Scope\CompanyScope;
use DateTimeInterface;
use Illuminate\Foundation\Auth\User as BaseUser;

class Authenticatable extends BaseUser
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope());
    }

    /**
     * @param  array  $ids
     * @return bool
     */
    public static function isValid(array $ids): bool
    {
        return static::whereIn('id', $ids)->count() === count(array_unique($ids));
    }

    /**
     * @param  int  $company_id
     * @param  array  $id
     * @return bool
     */
    public static function isAllBelongsTo(int $company_id, array $id): bool
    {
        return static::whereIn('id', $id)->where('company_id', $company_id)->count()
            === count(array_unique($id));
    }

    /**
     * 为数组 / JSON 序列化准备日期。
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
