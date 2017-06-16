<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 12:41
 */
namespace Notadd\Foundation\Permission;

use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Notadd\Foundation\Permission\Commands\PermissionCommand;

/**
 * Class PermissionServiceProvider.
 */
class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Boot service.
     */
    public function boot()
    {
        $this->commands(PermissionCommand::class);
    }

    /**
     * ServiceProvider register.
     */
    public function register()
    {
        $this->app->singleton('permission', function ($app) {
            return new PermissionManager($app, $app['permission.group']);
        });
        $this->app->singleton('permission.group', function ($app) {
            return new PermissionGroupManager($app, $app['permission.module']);
        });
        $this->app->singleton('permission.module', function ($app) {
            return new PermissionModuleManager($app);
        });
        $this->app->singleton('permission.type', function ($app) {
            return new PermissionTypeManager($app);
        });
    }
}
