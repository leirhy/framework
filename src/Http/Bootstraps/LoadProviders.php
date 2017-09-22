<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 10:58
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Http\Events\ProviderLoaded;

/**
 * Class BootProviders.
 */
class LoadProviders implements Bootstrap
{
    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        $application->registerConfiguredProviders();
        $application->boot();
        $application->make('events')->dispatch(new ProviderLoaded());
    }
}
