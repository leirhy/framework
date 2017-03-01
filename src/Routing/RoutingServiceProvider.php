<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 13:50
 */
namespace Notadd\Foundation\Routing;

use Illuminate\Routing\RoutingServiceProvider as IlluminateRoutingServiceProvider;

/**
 * Class RoutingServiceProvider.
 */
class RoutingServiceProvider extends IlluminateRoutingServiceProvider
{
    /**
     * Register the Redirector service.
     */
    protected function registerRedirector()
    {
        $this->app->singleton('redirect', function ($app) {
            $redirector = new Redirector($app['url']);
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });
    }
}
