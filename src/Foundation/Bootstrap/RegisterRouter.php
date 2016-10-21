<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:08
 */
namespace Notadd\Foundation\Bootstrap;
use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Routing\Events\RouteRegister;
/**
 * Class RegisterRouter
 * @package Notadd\Foundation\Bootstrap
 */
class RegisterRouter {
    /**
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app) {
        if($app->routesAreCached()) {
            $app->booted(function () use($app) {
                require $app->getCachedRoutesPath();
            });
        } else {
            $app->make('events')->fire(new RouteRegister($app, $app['router']));
            $app->booted(function () use($app) {
                $app['router']->getRoutes()->refreshNameLookups();
            });
        }
    }
}