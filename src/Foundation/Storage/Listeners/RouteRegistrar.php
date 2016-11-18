<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-17 19:21
 */
namespace Notadd\Foundation\Storage\Listeners;

use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;
use Notadd\Foundation\Storage\Apis\StorageApi;

class RouteRegistrar extends AbstractRouteRegistrar
{
    /**
     * @return void
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/setting'], function () {
            $this->router->post('storage', StorageApi::class.'@all');
        });
    }
}
