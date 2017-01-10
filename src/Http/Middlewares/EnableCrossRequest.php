<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-28 18:04
 */
namespace Notadd\Foundation\Http\Middlewares;

use Closure;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnableCrossRequest.
 */
class EnableCrossRequest
{
    /**
     * Middleware handler.
     *
     * @param          $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if($response instanceof Response) {
            $response->headers->set('Access-Control-Allow-Origin', '*', true);
            $response->headers->set('Access-Control-Allow-Headers', 'Origin,Content-Type,Cookie,Accept', true);
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PATCH,PUT,OPTIONS', true);
            $response->headers->set('Access-Control-Allow-Credentials', 'true', true);
        } else {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Headers', 'Origin,Content-Type,Cookie,Accept');
            $response->header('Access-Control-Allow-Methods', 'GET,POST,PATCH,PUT,OPTIONS');
            $response->header('Access-Control-Allow-Credentials', 'true');
        }
        return $response;
    }
}