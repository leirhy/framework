<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-22 11:49
 */
namespace Notadd\Foundation\Http\Middlewares;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Str;

/**
 * Class AssetsPublish.
 */
class AssetsPublish
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * AssetsPublish constructor.
     *
     * @param \Illuminate\Container\Container               $container
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     */
    public function __construct(Container $container, ResponseFactory $response)
    {
        $this->container = $container;
        $this->response = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (file_exists($file = $this->container->staticPath() . DIRECTORY_SEPARATOR . $request->path()) && !Str::endsWith('/', $request->path())) {
            $headers = [];
            switch (pathinfo($file, PATHINFO_EXTENSION)) {
                case 'css':
                    $headers['Content-Type'] = 'text/css';
                    break;
                case 'js':
                    $headers['Content-Type'] = 'application/json';
                    break;
                default:
                    $headers['Content-Type'] = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);
                    break;
            }

            return $this->response->make(file_get_contents($file), 200, $headers);
        } else {
            return $next($request);
        }
    }
}
