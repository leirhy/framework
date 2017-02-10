<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 16:42
 */
namespace Notadd\Foundation\Editor;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Editor\Listeners\RouteRegistrar;

/**
 * Class EditorServiceProvider.
 */
class EditorServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouteRegistrar::class);
    }
}
