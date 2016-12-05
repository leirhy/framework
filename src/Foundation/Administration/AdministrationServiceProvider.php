<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 13:24
 */
namespace Notadd\Foundation\Administration;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Administration\Listeners\RouteMatched;

/**
 * Class AdministrationServiceProvider.
 */
class AdministrationServiceProvider extends ServiceProvider
{
    /**
     * TODO: Method boot Description
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouteMatched::class);
    }

    /**
     * TODO: Method register Description
     */
    public function register()
    {
        $this->app->singleton('administration', function ($app) {
            return new Administration($app, $app['events']);
        });
    }
}
