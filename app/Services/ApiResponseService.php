<?php

namespace App\Services;

use App\Lib\Code;

class ApiResponseService
{
    public static function success($data = [], $code = Code::SUCCESS, $message = '操作成功')
    {
        if (empty($data)) {
            $data = new \stdClass();
        }
        $message = __($message);
        return response()->json([
            'data'    => $data,
            'msg' => $message??$code['msg'],
            'code'    => $code['code'],
            'status'  => true
        ]);
    }

    public static function error($code = Code::USER_ERROR, $message = null, $data = new \stdClass())
    {
        //过滤SQL报错语句
        if ($message === null || str_contains($message, 'SQLSTATE')) {
            $message = $code['msg'];
        }
        $message = __($message);
        return response()->json([
            'data'    => $data,
            'msg' => $message,
            'code'    => $code['code'],
            'status'  => false
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @param array $code
     */
    public static function successMessage(string $message = 'success', array $data = [] , array $code = Code::SUCCESS)
    {
        return self::success($data, $code, $message);
    }

    /**
     * @param string $message
     * @param array $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errorMessage(string $message = 'fail', array $code = Code::USER_ERROR)
    {
        return self::error($code, $message);
    }
}
