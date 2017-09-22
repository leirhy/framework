<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 11:05
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Support\Facades\Facade;
use Notadd\Foundation\AliasLoader;
use Notadd\Foundation\Application;
use Notadd\Foundation\Facades\FacadeRegister;
use Notadd\Foundation\Http\Contracts\Bootstrap;

/**
 * Class RegisterFacades.
 */
class RegisterFacades implements Bootstrap
{
    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($application);
        $aliasLoader = AliasLoader::getInstance($application->make('config')->get('app.aliases', []));
        $application->make('events')->dispatch(new FacadeRegister($aliasLoader));
        $aliasLoader->register();
    }
}
