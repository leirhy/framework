<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 13:24
 */
namespace Notadd\Foundation\Administration;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Administration\Listeners\RouteMatched;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class AdministrationServiceProvider.
 */
class AdministrationServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouteMatched::class);
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('administration', function ($app) {
            return new Administration($app, $app['events']);
        });
    }
}
