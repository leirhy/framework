<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:30
 */
namespace Notadd\Foundation\Http\Middlewares;
use Closure;
use Carbon\Carbon;
use Notadd\Foundation\Application;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Session\TokenMismatchException;
/**
 * Class VerifyCsrfToken
 * @package Notadd\Foundation\Http\Middlewares
 */
class VerifyCsrfToken {
    /**
     * @var \Notadd\Foundation\Application
     */
    protected $app;
    /**
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;
    /**
     * @var array
     */
    protected $except = [
        'api*'
    ];
    /**
     * @param \Notadd\Foundation\Application $app
     * @param \Illuminate\Contracts\Encryption\Encrypter $encrypter
     */
    public function __construct(Application $app, Encrypter $encrypter) {
        $this->app = $app;
        $this->encrypter = $encrypter;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next) {
        if($this->isReading($request) || $this->runningUnitTests() || $this->shouldPassThrough($request) || $this->tokensMatch($request)) {
            return $this->addCookieToResponse($request, $next($request));
        }
        throw new TokenMismatchException;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldPassThrough($request) {
        foreach($this->except as $except) {
            if($except !== '/') {
                $except = trim($except, '/');
            }
            if($request->is($except)) {
                return true;
            }
        }
        return false;
    }
    /**
     * @return bool
     */
    protected function runningUnitTests() {
        return $this->app->runningInConsole() && $this->app->runningUnitTests();
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function tokensMatch($request) {
        $sessionToken = $request->session()->token();
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        if(!$token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }
        if(!is_string($sessionToken) || !is_string($token)) {
            return false;
        }
        return hash_equals($sessionToken, $token);
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse($request, $response) {
        $config = config('session');
        $response->headers->setCookie(new Cookie('XSRF-TOKEN', $request->session()->token(), Carbon::now()->getTimestamp() + 60 * $config['lifetime'], $config['path'], $config['domain'], $config['secure'], false));
        return $response;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isReading($request) {
        return in_array($request->method(), [
            'HEAD',
            'GET',
            'OPTIONS'
        ]);
    }
}