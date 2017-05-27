<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-04 10:48
 */
namespace Notadd\Foundation\SearchEngine;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Notadd\Foundation\SearchEngine\Listeners\CsrfTokenRegister;
use Notadd\Foundation\SearchEngine\Listeners\PermissionGroupRegister;
use Notadd\Foundation\SearchEngine\Listeners\PermissionRegister;
use Notadd\Foundation\SearchEngine\Listeners\RouterRegister;

/**
 * Class SearchEngineServiceProvider.
 */
class SearchEngineServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouterRegister::class);
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('searchengine.optimization', function ($application) {
            return new Optimization($application, $application['setting'], $application['view']);
        });
    }
}
