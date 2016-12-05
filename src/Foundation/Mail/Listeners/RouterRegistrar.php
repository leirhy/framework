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

class RouterRegistrar extends AbstractRouteRegistrar
{
    /**
     * @return void
     * TODO: Method handle Description
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api'], function () {
            $this->router->post('mail', MailController::class . '@handle');
        });
    }
}
