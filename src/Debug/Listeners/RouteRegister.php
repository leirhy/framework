<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Debug\Listeners;

use Notadd\Foundation\Debug\Controllers\DebugController;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;

/**
 * Class RouteRegistrar.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('debug', DebugController::class . '@handle');
        });
    }
}
