<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-09-24 17:27
 */
namespace Notadd\Foundation\Member;

use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Member\Middleware\Permission;
use Notadd\Foundation\Member\Middleware\AdminPermission;
use Notadd\Foundation\Member\Commands\PermissionCommand;

/**
 * Class MemberServiceProvider.
 */
class MemberServiceProvider extends ServiceProvider
{
    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('member', function ($app) {
            return new MemberManagement($app);
        });
        $this->app->singleton('member.manager', function () {
            $manager = $this->app->make('member');

            return $manager->manager();
        });

        $this->registerPermission();

        $this->registerCommands();

        $this->registerMiddleware();
    }

    public function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('permission', Permission::class);
        $this->app['router']->aliasMiddleware('admin-permission', AdminPermission::class);
    }

    public function registerCommands()
    {
        $this->commands([
            PermissionCommand::class,
        ]);
    }

    public function registerPermission()
    {
        $this->app->instance('permission', function ($app) {
            return new PermissionManager;
        });
    }
}
