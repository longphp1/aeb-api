<?php

namespace App\Models\Traits;

use Spatie\Translatable\HasTranslations;

trait CustomHasTranslations
{
    use AdminLanguageCache,
        HasTranslations,
        ExtendToArray4Translate;

    /**
     * 获取字段翻译的状态
     * @return \Illuminate\Support\Collection
     */
    public function getTranslatedLocalesDiffAll()
    {
        $translatedLocals = $this->getTranslatedLocales($this->translatable[0]);

        $allLocals = self::getLanguageCache(\auth()->user()->company_id)
            ->where('enabled', 1)
            ->pluck('language_code')
            ->flatten();

        return collect($allLocals)->reject(function ($value) {
            return $value === 'zh_CN';
        })->mapWithKeys(function ($value) use ($translatedLocals) {
            if (in_array($value, $translatedLocals)) {
                return ['trans_' . $value => 1];
            }

            return ['trans_' . $value => 0];
        });
    }

    /**
     * @param  string  $key
     * @return \Illuminate\Support\Collection
     */
    public function getOtherTranslations(string $key)
    {
        $allLocals = self::getLanguageCache(\auth()->user()->company_id)
            ->where('enabled', 1)
            ->pluck('language_code')
            ->flatten();

        return collect($allLocals)->reject(function ($value) {
            return $value === 'zh_CN';
        })->mapWithKeys(function ($value) {
            return [$value => ''];
        })->merge(collect($this->getTranslations($key))->reject(function ($value, $key) {
            return $key === 'zh_CN';
        }));
    }
}
