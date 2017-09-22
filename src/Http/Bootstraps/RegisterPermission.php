<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 12:05
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Permission\Events\PermissionGroupRegister;
use Notadd\Foundation\Permission\Events\PermissionModuleRegister;
use Notadd\Foundation\Permission\Events\PermissionRegister;
use Notadd\Foundation\Permission\Events\PermissionTypeRegister;

/**
 * Class RegisterPermission.
 */
class RegisterPermission implements Bootstrap
{
    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        if ($application->isInstalled()) {
            $application->make('events')->dispatch(new PermissionModuleRegister($application['permission.module']));
            $application->make('events')->dispatch(new PermissionGroupRegister($application['permission']));
            $application->make('events')->dispatch(new PermissionRegister($application['permission']));
            $application->make('events')->dispatch(new PermissionTypeRegister($application['permission.type']));
        }
    }
}
