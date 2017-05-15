<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 14:08
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Routing\Events\RouteRegister;

/**
 * Class RegisterRouter.
 */
class RegisterRouter
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
            if ($application->routesAreCached()) {
                $application->booted(function () use ($application) {
                    require $application->getCachedRoutesPath();
                });
            } else {
                $application->make('events')->fire(new RouteRegister($application, $application['router']));
                $application->booted(function () use ($application) {
                    $application['router']->getRoutes()->refreshNameLookups();
                });
            }
        }
    }
}
