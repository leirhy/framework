<?php
/**
 * Created by PhpStorm.
 * User: TwilRoad
 * Date: 2016/11/16 0016
 * Time: 13:52.
 */
namespace Notadd\Foundation\Debug;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Debug\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Debug\Listeners\RouteRegister;

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
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
    }
}
