<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-02 15:55
 */
namespace Notadd\Foundation\Attachment\Listeners;

use Notadd\Foundation\Attachment\Apis\AttachmentApi;
use Notadd\Foundation\Attachment\Apis\StorageApi;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;

/**
 * Class RouteRegistrar.
 */
class RouteRegistrar extends AbstractRouteRegistrar
{
    /**
     * @return void
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['web', 'auth:api'], 'prefix' => 'api/attachment'], function () {
            $this->router->post('/', AttachmentApi::class.'@handle');
            $this->router->post('storage', StorageApi::class.'@handle');
        });
    }
}
