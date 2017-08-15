<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Debug\Listeners;

use Notadd\Foundation\Debug\Controllers\DebugController;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Register.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/debug'], function () {
            $this->router->post('get', DebugController::class . '@get');
            $this->router->post('publish', DebugController::class . '@publish');
            $this->router->post('set', DebugController::class . '@set');
        });
    }
}
