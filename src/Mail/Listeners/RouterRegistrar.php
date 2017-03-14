<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 18:08
 */
namespace Notadd\Foundation\Mail\Listeners;

use Notadd\Foundation\Mail\Controllers\MailController;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;

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
            $this->router->post('mail/test', MailController::class . '@test');
            $this->router->post('mail', MailController::class . '@handle');
        });
    }
}
