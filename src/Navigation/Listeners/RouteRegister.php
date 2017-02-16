<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-16 17:43
 */
namespace Notadd\Foundation\Navigation\Listeners;

use Notadd\Foundation\Navigation\Controllers\GroupController;
use Notadd\Foundation\Navigation\Controllers\ItemController;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegistrar
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/navigation'], function () {
            $this->router->post('group/delete', GroupController::class . '@delete');
            $this->router->post('group/edit', GroupController::class . '@edit');
            $this->router->post('group/fetch', GroupController::class . '@fetch');
            $this->router->post('item/delete', ItemController::class . '@delete');
            $this->router->post('item/edit', ItemController::class . '@edit');
            $this->router->post('item/fetch', ItemController::class . '@fetch');
        });
    }
}
