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
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnableCrossRequest.
 */
class EnableCrossRequest
{
    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * EnableCrossRequest constructor.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Middleware handler.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Headers'     => 'Origin,Content-Type,Cookie,Accept',
            'Access-Control-Allow-Methods'     => 'GET,POST,PATCH,PUT,OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        if ($request->getMethod() == 'OPTIONS') {
            return $this->response->make('OK', 200, $headers);
        }
        $response = $next($request);
        if ($response instanceof Response) {
            collect($headers)->each(function ($value, $key) use($response) {
                $response->headers->set($key, $value);
            });
        } else {
            collect($headers)->each(function ($value, $key) use($response) {
                $response->header($key, $value);
            });
        }

        return $response;
    }
}