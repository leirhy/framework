<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:05
 */
namespace Notadd\Foundation\Bootstrap;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Notadd\Foundation\AliasLoader;
/**
 * Class RegisterFacades
 * @package Notadd\Foundation\Bootstrap
 */
class RegisterFacades {
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app) {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication($app);
        AliasLoader::getInstance($app->make('config')->get('app.aliases', []))->register();
    }
}