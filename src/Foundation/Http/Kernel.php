<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 20:04
 */
namespace Notadd\Foundation\Http;
use Exception;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Notadd\Foundation\Bootstrap\BootProviders;
use Notadd\Foundation\Bootstrap\ConfigureLogging;
use Notadd\Foundation\Bootstrap\DetectEnvironment;
use Notadd\Foundation\Bootstrap\HandleExceptions;
use Notadd\Foundation\Bootstrap\LoadConfiguration;
use Notadd\Foundation\Bootstrap\RegisterFacades;
use Notadd\Foundation\Bootstrap\RegisterProviders;
use Notadd\Foundation\Bootstrap\RegisterRouter;
use Throwable;
use Illuminate\Routing\Router;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Facades\Facade;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Http\Kernel as KernelContract;
use Symfony\Component\Debug\Exception\FatalThrowableError;
/**
 * Class Kernel
 * @package Notadd\Http
 */
class Kernel implements KernelContract {
    /**
     * @var \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application
     */
    protected $app;
    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * @var array
     */
    protected $bootstrappers = [
        DetectEnvironment::class,
        LoadConfiguration::class,
        ConfigureLogging::class,
        HandleExceptions::class,
        RegisterFacades::class,
        RegisterProviders::class,
        RegisterRouter::class,
        BootProviders::class,
    ];
    /**
     * @var array
     */
    protected $middleware = [];
    /**
     * @var array
     */
    protected $middlewareGroups = [];
    /**
     * @var array
     */
    protected $routeMiddleware = [];
    /**
     * @var array
     */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        SubstituteBindings::class,
        Authorize::class,
    ];
    /**
     * Kernel constructor.
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     * @param \Illuminate\Routing\Router $router
     */
    public function __construct(Application $app, Router $router) {
        $this->app = $app;
        $this->router = $router;
        $router->middlewarePriority = $this->middlewarePriority;
        foreach($this->middlewareGroups as $key => $middleware) {
            $router->middlewareGroup($key, $middleware);
        }
        foreach($this->routeMiddleware as $key => $middleware) {
            $router->middleware($key, $middleware);
        }
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle($request) {
        try {
            $request->enableHttpMethodParameterOverride();
            $response = $this->sendRequestThroughRouter($request);
        } catch(Exception $e) {
            $this->reportException($e);
            $response = $this->renderException($request, $e);
        } catch(Throwable $e) {
            $this->reportException($e = new FatalThrowableError($e));
            $response = $this->renderException($request, $e);
        }
        $this->app['events']->fire('kernel.handled', [
            $request,
            $response
        ]);
        return $response;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendRequestThroughRouter($request) {
        $this->app->instance('request', $request);
        Facade::clearResolvedInstance('request');
        $this->bootstrap();
        return (new Pipeline($this->app))->send($request)->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)->then($this->dispatchToRouter());
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     * @return void
     */
    public function terminate($request, $response) {
        $middlewares = $this->app->shouldSkipMiddleware() ? [] : array_merge($this->gatherRouteMiddleware($request), $this->middleware);
        foreach($middlewares as $middleware) {
            if(!is_string($middleware)) {
                continue;
            }
            list($name, $parameters) = $this->parseMiddleware($middleware);
            $instance = $this->app->make($name);
            if(method_exists($instance, 'terminate')) {
                $instance->terminate($request, $response);
            }
        }
        $this->app->terminate();
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function gatherRouteMiddleware($request) {
        if($route = $request->route()) {
            return $this->router->gatherRouteMiddleware($route);
        }
        return [];
    }
    /**
     * @param string $middleware
     * @return array
     */
    protected function parseMiddleware($middleware) {
        list($name, $parameters) = array_pad(explode(':', $middleware, 2), 2, []);
        if(is_string($parameters)) {
            $parameters = explode(',', $parameters);
        }
        return [
            $name,
            $parameters
        ];
    }
    /**
     * @param string $middleware
     * @return $this
     */
    public function prependMiddleware($middleware) {
        if(array_search($middleware, $this->middleware) === false) {
            array_unshift($this->middleware, $middleware);
        }
        return $this;
    }
    /**
     * @param string $middleware
     * @return $this
     */
    public function pushMiddleware($middleware) {
        if(array_search($middleware, $this->middleware) === false) {
            $this->middleware[] = $middleware;
        }
        return $this;
    }
    /**
     * @return void
     */
    public function bootstrap() {
        if(!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
    }
    /**
     * @return \Closure
     */
    protected function dispatchToRouter() {
        return function ($request) {
            $this->app->instance('request', $request);
            return $this->router->dispatch($request);
        };
    }
    /**
     * @param string $middleware
     * @return bool
     */
    public function hasMiddleware($middleware) {
        return in_array($middleware, $this->middleware);
    }
    /**
     * @return array
     */
    protected function bootstrappers() {
        return $this->bootstrappers;
    }
    /**
     * @param \Exception $e
     * @return void
     */
    protected function reportException(Exception $e) {
        $this->app[ExceptionHandler::class]->report($e);
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Exception $e) {
        return $this->app[ExceptionHandler::class]->render($request, $e);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function getApplication() {
        return $this->app;
    }
}