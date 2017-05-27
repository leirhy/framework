<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 12:05
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Permission\Events\PermissionGroupRegister;
use Notadd\Foundation\Permission\Events\PermissionModuleRegister;
use Notadd\Foundation\Permission\Events\PermissionRegister;
use Notadd\Foundation\Permission\Events\PermissionTypeRegister;

/**
 * Class RegisterPermission.
 */
class RegisterPermission
{
    /**
     * Bootstrap the given application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     *
     * @return void
     */
    public function bootstrap(Application $application)
    {
        if ($application->isInstalled()) {
            $application->make('events')->fire(new PermissionModuleRegister($application, $application['permission.module']));
            $application->make('events')->fire(new PermissionGroupRegister($application, $application['permission']));
            $application->make('events')->fire(new PermissionRegister($application, $application['permission']));
            $application->make('events')->fire(new PermissionTypeRegister($application, $application['permission.type']));
        }
    }
}
