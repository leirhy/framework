<?php
/**
 * Created by PhpStorm.
 * User: TwilRoad
 * Date: 2016/11/16 0016
 * Time: 13:54.
 */
namespace Notadd\Foundation\Debug\Listeners;

use Notadd\Foundation\Debug\Controllers\DebugController;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;

/**
 * Class RouteRegistrar.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('debug', DebugController::class . '@handle');
        });
    }
}
