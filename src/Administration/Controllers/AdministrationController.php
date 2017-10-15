<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-15 17:12
 */
namespace Notadd\Foundation\Administration\Controllers;

use Illuminate\Http\JsonResponse;
use Notadd\Foundation\Auth\ThrottlesLogins;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Validation\Rule;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class AdministrationController.
 */
class AdministrationController extends Controller
{
    use ThrottlesLogins;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function token(): JsonResponse
    {
        $this->validate($this->request, [
            'name'     => Rule::required(),
            'password' => Rule::required(),
        ], [
            'name.required'     => '用户名必须填写',
            'password.required' => '用户密码必须填写',
        ]);
        if ($this->hasTooManyLoginAttempts($this->request)) {
            $seconds = $this->limiter()->availableIn($this->throttleKey($this->request));
            $message = $this->translator->get('auth.throttle', ['seconds' => $seconds]);

            return $this->response->json([
                'message' => $message,
            ], 403);
        }
        if (!$this->auth->guard()->attempt($this->request->only([
            'name',
            'password',
        ], $this->request->has('remember', true)))) {
            return $this->response->json([
                'message' => '认证失败！',
            ], 403);
        }
        $this->request->session()->regenerate();
        $this->clearLoginAttempts($this->request);
        $user = $this->auth->guard()->user();
        try {
            if (!$token = $this->jwt->fromUser($user)) {
                return $this->response->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $exception) {
            return $this->response->json(['error' => 'could_not_create_token'], 500);
        }

        return $this->response->json(compact('token'));
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|mixed
     */
    public function guard()
    {
        return $this->auth->guard();
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'name';
    }
}
