<?php

namespace App\Http\Middleware;

use Closure;

class Localize
{
    protected const LOCALE = [
        'hk' => 'zh_TW',
        'cn' => 'zh_CN',
        'en' => 'en_US',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $this->getLocaleForRequest($request);

        if (! is_null($locale)) {
            if (isset(self::LOCALE[$locale])) {
                app()->setLocale(self::LOCALE[$locale]);
                //设置翻译字段备用翻译
                config('translatable.fallback_locale', self::LOCALE[$locale]);
            } else {
                app()->setLocale($locale);
                //设置翻译字段备用翻译
                config('translatable.fallback_locale', $locale);
            }
        }

        return $next($request);
    }

    /**
     * Get the locale for the current request.
     * @param $request
     * @return string
     */
    public function getLocaleForRequest($request)
    {
        $headerLocale = $request->header('Language');

        //Query参数会覆盖掉Header里面的参数
        $queryLocale = $request->query('lang');

        $locale = $queryLocale ?: $headerLocale;

        if (! is_null($locale)) {
            return $locale;
        }

        return 'zh_CN';
    }
}
