<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 14:08
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Routing\Events\RouteRegister;

/**
 * Class RegisterRouter.
 */
class RegisterRouter implements Bootstrap
{
    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        if ($application->isInstalled()) {
            if ($application->routesAreCached()) {
                $application->booted(function () use ($application) {
                    require $application->getCachedRoutesPath();
                });
            } else {
                $application->make('events')->dispatch(new RouteRegister($application['router']));
                $application->booted(function () use ($application) {
                    $application['router']->getRoutes()->refreshNameLookups();
                });
            }
        }
    }
}
