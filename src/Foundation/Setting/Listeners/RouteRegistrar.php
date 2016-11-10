<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-08 17:02
 */
namespace Notadd\Foundation\Setting\Listeners;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;
use Notadd\Foundation\Setting\Controllers\ApiController;
/**
 * Class RouteRegistrar
 * @package Notadd\Foundation\Setting\Listeners
 */
class RouteRegistrar extends AbstractRouteRegistrar {
    /**
     * @return void
     */
    public function handle() {
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/setting'], function() {
            $this->router->post('all', ApiController::class . '@all');
            $this->router->post('set', ApiController::class . '@set');
        });
    }
}