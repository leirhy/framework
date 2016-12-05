<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:45
 */
namespace Notadd\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class ResetsPasswords.
 */
trait ResetsPasswords
{
    use RedirectsUsers;

    /**
     * TODO: Method showResetForm Description
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * TODO: Method reset Description
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $response = $this->broker()->reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        return $response == Password::PASSWORD_RESET ? $this->sendResetResponse($response) : $this->sendResetFailedResponse($request,
            $response);
    }

    /**
     * TODO: Method credentials Description
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }

    /**
     * TODO: Method resetPassword Description
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string                                      $password
     *
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();
        $this->guard()->login($user);
    }

    /**
     * TODO: Method sendResetResponse Description
     *
     * @param string $response
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())->with('status', trans($response));
    }

    /**
     * TODO: Method sendResetFailedResponse Description
     *
     * @param \Illuminate\Http\Request
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }

    /**
     * TODO: Method broker Description
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * TODO: Method guard Description
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
