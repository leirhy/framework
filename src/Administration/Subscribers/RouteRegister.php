<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-26 14:58
 */
namespace Notadd\Foundation\Administration\Subscribers;

use Notadd\Foundation\Administration\Controllers\MenuController;
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
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/administration'], function () {
            $this->router->resource('menus', MenuController::class)->methods([
                'index' => 'list',
                'store' => 'update',
            ])->names([
                'index' => 'menus.list',
                'store' => 'menus.update',
            ])->only([
                'index',
                'store',
            ]);
        });
    }
}
