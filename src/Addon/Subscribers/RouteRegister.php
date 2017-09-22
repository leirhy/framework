<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-22 17:51
 */
namespace Notadd\Foundation\Addon\Subscribers;

use Notadd\Foundation\Addon\Controllers\AddonController;
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
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('extension/enable', AddonController::class . '@enable');
            $this->router->post('extension/exports', AddonController::class . '@exports');
            $this->router->post('extension/imports', AddonController::class . '@imports');
            $this->router->post('extension/install', AddonController::class . '@install');
            $this->router->post('extension/uninstall', AddonController::class . '@uninstall');
            $this->router->post('extension/update', AddonController::class . '@update');
            $this->router->post('extension', AddonController::class . '@handle');
        });
    }
}
