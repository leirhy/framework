<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 15:08
 */
namespace Notadd\Foundation\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class FrontPermission.
 */
class FrontPermission extends Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     * @param                           $permissions
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permissions, $guard = 'admin')
    {
        if ($this->auth->guard($guard)->guest() || ! $request->user($guard)->hasFrontPermission(explode('|', $permissions))) {
            if ($this->wantsJson()) {
                return new JsonResponse('Forbidden', 403);
            }

            abort(403);
        }

        return $next($request);
    }
}
