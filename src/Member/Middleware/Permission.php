<?php

/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-16 13:41
 */
namespace Notadd\Foundation\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class Permission.
 */
class Permission
{
    protected $auth;

    public function __construct()
    {
        $this->auth = app('auth');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     * @param                           $permissions
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permissions)
    {
        if ($this->auth->guest() || ! $request->user()->hasPermission(explode('|', $permissions))) {
            if ($this->wantsJson()) {
                return new JsonResponse('Forbidden', 403);
            }

            abort(403);
        }

        return $next($request);
    }

    protected function wantsJson()
    {
        return (app('request')->ajax() || app('request')->wantsJson()) ? true : false;
    }
}
