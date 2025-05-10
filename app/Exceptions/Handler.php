<?php

namespace App\Exceptions;

use App\Lib\Code;
use App\Lib\ValidationErrorCodes;
use App\Services\ApiResponseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if($request->is('api/*') && $e instanceof ValidationException) {
            return ApiResponseService::error(Code::SERVICE_ERROR, $e->getMessage());
        }

        if($e instanceof AuthenticationException) {
            return ApiResponseService::error(Code::ACCESS_UNAUTHORIZED, __('请先登录'))->setStatusCode(401);
        }

        if($e instanceof NotFoundHttpException) {
            return ApiResponseService::error(Code::INTERFACE_NOT_EXIST)->setStatusCode(404);
        }

        if ($e instanceof ThrottleRequestsException) {
            return ApiResponseService::error(Code::USER_DUPLICATE_REQUEST)->setStatusCode(429);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return ApiResponseService::error(Code::USER_ACCESS_BLOCKED)->setStatusCode(405);
        }

        if($e instanceof RouteNotFoundException) {
            return ApiResponseService::error(Code::ACCESS_UNAUTHORIZED);
        }

        if ($e instanceof ModelNotFoundException) {
            return ApiResponseService::errorMessage('数据不存在', Code::ACCESS_UNAUTHORIZED);
        }

        if ($request->is('api/*')) {
            if ($e->getCode() == Code::SERVICE_ERROR || $e->getCode() == Code::USER_VERIFICATION_CODE_ERROR || $e->getCode() == Code::USER_REGISTRATION_ERROR) {
                return ApiResponseService::error($e->getCode(), $e->getMessage());
            }

            if($e->getCode() == Code::ACCESS_UNAUTHORIZED) {
                return ApiResponseService::error($e->getCode(), $e->getMessage())->setStatusCode(401);
            }

            info('服务器端错误：', ['msg' =>$e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()]);
            return ApiResponseService::error(Code::SERVICE_ERROR);
        }

        return parent::render($request, $e);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Validation\ValidationException $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        Log::channel('single')->debug(get_class($request)); //调用该变量,防止空变量传入
        $error = $exception->errors();
        $message = array_values($error)[0][0];
        return response()->json(['code' => 'A0400', 'msg' => $message, 'data' => $error], 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param ValidationException $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    protected function invalid($request, ValidationException $exception)
    {
        Log::channel('single')->debug(get_class($request)); //调用该变量,防止空变量传入
        $error = $exception->errors();
        $message = array_values($error)[0][0];
        return response()->json(['code' => 'A0400', 'msg' => $message, 'data' => $error], 200);
    }
}
