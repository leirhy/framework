<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-18 19:02
 */
namespace Notadd\Foundation\Module\Listeners;

use Notadd\Foundation\Module\Controllers\ModuleController;
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
            $this->router->post('module/enable', ModuleController::class . '@enable');
            $this->router->post('module/install', ModuleController::class . '@install');
            $this->router->post('module/uninstall', ModuleController::class . '@uninstall');
            $this->router->post('module/update', ModuleController::class . '@update');
            $this->router->post('module', ModuleController::class . '@handle');
        });
    }
}
