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
use Notadd\Foundation\Permission\Events\PermissionRegister;

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
            $application['permission']->group('global', [
                'description' => '全局权限定义。',
                'identification' => 'global',
                'name' => '全局权限',
            ]);
            $application->make('events')->fire(new PermissionRegister($application, $application['permission']));
        }
    }
}
