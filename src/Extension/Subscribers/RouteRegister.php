<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-22 17:51
 */
namespace Notadd\Foundation\Extension\Subscribers;

use Notadd\Foundation\Extension\Controllers\ExtensionController;
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
            $this->router->post('extension/enable', ExtensionController::class . '@enable');
            $this->router->post('extension/exports', ExtensionController::class . '@exports');
            $this->router->post('extension/imports', ExtensionController::class . '@imports');
            $this->router->post('extension/install', ExtensionController::class . '@install');
            $this->router->post('extension/uninstall', ExtensionController::class . '@uninstall');
            $this->router->post('extension/update', ExtensionController::class . '@update');
            $this->router->post('extension', ExtensionController::class . '@handle');
        });
    }
}
