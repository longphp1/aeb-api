<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AccidentException;
use App\Http\Controllers\Controller;
use App\Lib\Code;
use App\Models\SysUser;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:sys_user',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = new SysUser;
        $user->username = request()->username;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);

        $user->save();

        return ApiResponseService::success($user);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'captchaKey' => 'required|string',
            'captchaCode' => 'required|string|captcha:' . ($request->get('captchaKey') ?? 'captchaKey'),
        ]);
        if (!captcha_api_check($request->get('captchaCode') , $request->get('captchaKey'))){
            return ApiResponseService::errorMessage('Verification code error',Code::USER_VERIFICATION_CODE_ERROR);
        }
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return ApiResponseService::errorMessage('Unauthorized',Code::USER_PASSWORD_ERROR);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return ApiResponseService::success();
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return ApiResponseService::success([
            'accessToken' => $token,
            'refreshToken' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => auth()->factory()->getTTL() * 3600
        ]);
    }


    /**
     * 获得验证码
     * @throws AccidentException
     */
    public function getCaptcha()
    {
        try {
            $captcha = app('captcha')->create('default', true);
            // 获取图片二进制内容
            $imageContent = (string)$captcha['img']; // 或 $captcha['img']->getEncoded()
            // 转换为 Base64
            $base64Image = 'data:image/jpeg;base64,' . base64_encode($imageContent);
            $captchaData['captchaBase64'] = $base64Image;
            $captchaData['captchaKey'] = $captcha['key'];
        } catch (\Exception $e) {
            return ApiResponseService::error(__('验证码生成失败'));
        }
        return ApiResponseService::success($captchaData);
    }
}

