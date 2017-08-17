<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-02 20:29
 */
namespace Notadd\Foundation\Module;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Notadd\Foundation\Module\Commands\GenerateCommand;
use Notadd\Foundation\Module\Commands\ListCommand;
use Notadd\Foundation\Module\Commands\ListUnloadedCommand;
use Notadd\Foundation\Module\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Module\Listeners\PermissionGroupRegister;
use Notadd\Foundation\Module\Listeners\PermissionRegister;
use Notadd\Foundation\Module\Listeners\RouteRegister;

/**
 * Class ModuleServiceProvider.
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
        $this->commands([
            GenerateCommand::class,
            ListCommand::class,
            ListUnloadedCommand::class,
        ]);
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('module', function ($app) {
            return new ModuleManager($app, $app['config'], $app['events'], $app['files']);
        });
    }
}
