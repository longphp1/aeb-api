<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AccidentException;
use App\Http\Controllers\Controller;
use App\Models\User;
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
        $request->validate($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);

        $user->save();

        return response()->json($user, 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'captchaKey' => 'required|string',
            'captchaCode' => 'required|string|captcha_api:' . ($request->get('captchaKey') ?? 'captchaKey'),
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
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

        return response()->json(['message' => 'Successfully logged out']);
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
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
            return eRet(__('验证码生成失败'));
        }
        return formatRet(1, 'success', $captchaData);
    }
}

