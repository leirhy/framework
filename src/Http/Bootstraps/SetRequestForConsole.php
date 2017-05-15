<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 11:07
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Class SetRequestForConsole.
 */
class SetRequestForConsole
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
        $url = $application->make('config')->get('app.url', 'http://localhost');
        $application->instance('request', Request::create($url, 'GET', [], [], [], $_SERVER));
    }
}
