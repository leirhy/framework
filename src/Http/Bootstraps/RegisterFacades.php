<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:05
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Notadd\Foundation\AliasLoader;
use Notadd\Foundation\Facades\FacadeRegister;

/**
 * Class RegisterFacades.
 */
class RegisterFacades
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
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($application);
        $aliasLoader = AliasLoader::getInstance($application->make('config')->get('app.aliases', []));
        $application->make('events')->fire(new FacadeRegister($application, $aliasLoader));
        $aliasLoader->register();
    }
}
