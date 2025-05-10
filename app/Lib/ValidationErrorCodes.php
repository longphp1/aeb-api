<?php

namespace App\Lib;

class ValidationErrorCodes
{
    const RULE_ERROR_MAP = [
        'required' => 'A0410', // 请求必填参数为空
        'string' => 'A0421',   // 参数格式不匹配
        'captcha_api' => 'A0131', // 短信校验码输入错误
        'integer' => 'A0422', // 参数必须为整数
        'numeric' => 'A0423', // 参数必须为数字
        'email' => 'A0424',   // 邮箱格式不正确
        'url' => 'A0425',     // URL 格式不正确
        'array' => 'A0426',   // 参数必须为数组
        'date' => 'A0427',    // 日期格式不正确
        'min' => 'A0431',     // 参数值小于最小值
        'max' => 'A0432',     // 参数值大于最大值
        'in' => 'A0441',      // 参数值不在允许的范围内
        'unique' => 'A0451',  // 参数值不唯一
    ];

    const RULE_REGEX_MAP = [
        'required' => null, // 因为必填校验通常不是通过正则，所以设为 null
        'string' => '/^.*$/', // 简单匹配任意字符串
        'captcha_api' => '/^.*$/', // 假设短信验证码是 6 位数字
        'integer' => '/^-?\d+$/', // 匹配整数
        'numeric' => '/^-?\d+(\.\d+)?$/', // 匹配数字
        'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', // 匹配邮箱格式
        'url' => '/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$/', // 匹配 URL 格式
        'array' => null, // 数组校验通常不是通过正则，所以设为 null
        'date' => '/^\d{4}-\d{2}-\d{2}$/', // 假设日期格式为 YYYY-MM-DD
        'min' => null, // 最小值校验通常不是通过正则，所以设为 null
        'max' => null, // 最大值校验通常不是通过正则，所以设为 null
        'in' => null, // 范围校验通常不是通过正则，所以设为 null
        'unique' => null, // 唯一性校验通常不是通过正则，所以设为 null
    ];

    public static function getCode(string $rule): string
    {
        return self::RULE_ERROR_MAP[$rule] ?? 'B0001'; // 默认系统错误
    }
}
