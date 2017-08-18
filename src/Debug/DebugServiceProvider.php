<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Debug;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Debug\Listeners\PermissionGroupRegister;
use Notadd\Foundation\Debug\Listeners\PermissionRegister;
use Notadd\Foundation\Debug\Listeners\RouteRegister;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class DebugServiceProvider.
 */
class DebugServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
    }
}
