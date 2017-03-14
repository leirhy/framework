<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-22 17:51
 */
namespace Notadd\Foundation\Extension\Listeners;

use Notadd\Foundation\Extension\Controllers\ExtensionController;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;

/**
 * Class RouteRegistrar.
 */
class RouteRegister extends AbstractRouteRegistrar
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('extension/enable', ExtensionController::class . '@enable');
            $this->router->post('extension', ExtensionController::class . '@handle');
        });
    }
}
