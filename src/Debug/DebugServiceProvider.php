<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Debug;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Debug\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Debug\Listeners\RouteRegister;
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
            $this->app->make(SettingsRepository::class)->get('debug.enabled', false) && Artisan::call('vendor:publish', [
                '--force' => true,
            ]);
        });
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
    }
}
