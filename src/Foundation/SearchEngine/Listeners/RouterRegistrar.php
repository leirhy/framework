<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 18:53
 */
namespace Notadd\Foundation\SearchEngine\Listeners;

use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;
use Notadd\Foundation\SearchEngine\Apis\SeoApi;

class RouterRegistrar extends AbstractRouteRegistrar
{

    /**
     * @return void
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('seo', SeoApi::class . '@handle');
        });
    }
}
