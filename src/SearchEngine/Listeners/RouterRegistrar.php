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
use Notadd\Foundation\SearchEngine\Controllers\SeoController;

/**
 * Class RouterRegistrar.
 */
class RouterRegistrar extends AbstractRouteRegistrar
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('seo', SeoController::class . '@handle');
        });
    }
}
