<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Debug;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Debug\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Debug\Listeners\PermissionGroupRegister;
use Notadd\Foundation\Debug\Listeners\PermissionRegister;
use Notadd\Foundation\Debug\Listeners\RouteRegister;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Notadd\Foundation\Http\Events\RequestHandled;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

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
        $this->app->isInstalled() && $this->app->make(Dispatcher::class)->listen(RequestHandled::class, function () {
            if ($this->app->make(SettingsRepository::class)->get('debug.enabled', false)) {
                $this->app->make(Kernel::class)->call('vendor:publish', [
                    '--force' => true,
                ]);
            }
        });
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
    }
}
