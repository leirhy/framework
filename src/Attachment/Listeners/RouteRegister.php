<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-02 15:55
 */
namespace Notadd\Foundation\Attachment\Listeners;

use Notadd\Foundation\Attachment\Controllers\AttachmentController;
use Notadd\Foundation\Attachment\Controllers\CdnController;
use Notadd\Foundation\Attachment\Controllers\StorageController;
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
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/attachment'], function () {
            $this->router->post('get', AttachmentController::class . '@get');
            $this->router->post('set', AttachmentController::class . '@set');
            $this->router->post('cdn', CdnController::class . '@handle');
            $this->router->post('storage', StorageController::class . '@handle');
        });
    }
}
