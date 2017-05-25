<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 12:41
 */
namespace Notadd\Foundation\Permission;

use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class PermissionServiceProvider.
 */
class PermissionServiceProvider extends ServiceProvider
{
    /**
     * ServiceProvider register.
     */
    public function register()
    {
        $this->app->singleton('permission', function ($app) {
            return new PermissionManager($app);
        });
        $this->app->singleton('permission.type', function ($app) {
            return new PermissionTypeManager($app);
        });
    }
}
