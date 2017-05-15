<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-09-24 17:27
 */
namespace Notadd\Foundation\Member;

use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Notadd\Foundation\Member\Middleware\Permission;
use Notadd\Foundation\Member\Middleware\FrontPermission;
use Notadd\Foundation\Member\Middleware\AdminPermission;

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

        $this->registerMiddleware();
    }

    public function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('permission', Permission::class);
        $this->app['router']->aliasMiddleware('permission.admin', AdminPermission::class);
        $this->app['router']->aliasMiddleware('permission.front', FrontPermission::class);
    }
}
