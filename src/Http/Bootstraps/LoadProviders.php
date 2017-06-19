<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 10:58
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;

/**
 * Class BootProviders.
 */
class LoadProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param \Illuminate\Contracts\Foundation\Application $application
     *
     * @return void
     */
    public function bootstrap(Application $application)
    {
        $application->registerConfiguredProviders();
        $application->boot();
    }
}
