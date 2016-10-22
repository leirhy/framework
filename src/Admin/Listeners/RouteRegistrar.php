<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 16:05
 */
namespace Notadd\Admin\Listeners;
use Notadd\Admin\Controllers\IndexController;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;
/**
 * Class RouteRegistrar
 * @package Notadd\Admin\Listeners
 */
class RouteRegistrar extends AbstractRouteRegistrar {
    /**
     * @return void
     */
    public function handle() {
        $this->router->group(['middleware' => 'web', 'prefix' => 'admin'], function() {
            $this->router->resource('/', IndexController::class);
        });
    }
}