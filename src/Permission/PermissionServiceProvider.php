<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-04 12:41
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class PermissionServiceProvider.
 */
class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe('');
    }

    /**
     * ServiceProvider register.
     */
    public function register()
    {
        $this->app->singleton('permission', function ($app) {
            return new PermissionManager($app);
        });
    }
}
