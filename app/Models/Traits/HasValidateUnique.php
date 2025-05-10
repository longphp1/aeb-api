<?php

namespace App\Models\Traits;

use App\Exceptions\AccidentException;
use Illuminate\Support\Arr;

trait HasValidateUnique
{

    /**
     * 检验字段唯一性失败
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  null|int|array  $excludeId
     * @param  null  $scope
     * @param string $type
     * @return void
     * @throws AccidentException
     */
    public static function validateUniqueOrFail(string $attribute, $value, $excludeId = null, $scope = null, $type = 'normal')
    {
        $bool = ($type == 'normal') ? static::validateUnique($attribute, $value, $excludeId) : static::validateUniqueForLanguage($attribute, $value, $excludeId);
        if (!$bool) {
            static::failedValidatingUnique($attribute, $scope);
        }
    }

    /**
     * 检验字段唯一性
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array|null  $excludeId
     * @return bool
     */
    protected static function validateUnique(string $attribute, $value, $excludeId = null)
    {
        $query = static::query()->where($attribute, $value)
            ->whereNotNull($attribute);

        if (! is_null($excludeId) && $excludeId !== 'NULL') {
            if ((is_array($excludeId) && array_is_list($excludeId)) || is_numeric($excludeId)) {
                $query->whereKeyNot($excludeId);
            } else {
                foreach ($excludeId as $key => $value)
                $query->whereNotIn($key, Arr::wrap($value));
            }
        }

        return $query->count() === 0;
    }

    public static function validateUniqueForLanguage(string $attribute, $value, $excludeId = null)
    {
        $locate = \request()->header('language');
        $query = static::query()->whereRaw("name->'$.$locate' = '$value'")
            ->whereNotNull($attribute);

        if (! is_null($excludeId) && $excludeId !== 'NULL') {
            $query->whereKeyNot($excludeId);
        }

        return $query->count() === 0;
    }

    /**
     * 检验字段唯一性失败
     * @param $attribute
     * @param  null  $scope
     * @return void
     * @throws AccidentException
     */
    protected static function failedValidatingUnique($attribute, $scope = null)
    {
        if ($scope) {
            $trans = 'validation.attributes.'.$scope.'.'.$attribute;
        } else {
            $trans = 'validation.attributes.' . $attribute;
        }

        throw new AccidentException(
            trans('validation.unique', [
                'attribute' => trans($trans),
            ])
        );
    }
}
