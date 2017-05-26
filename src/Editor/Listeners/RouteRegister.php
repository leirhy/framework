<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-10 16:44
 */
namespace Notadd\Foundation\Editor\Listeners;

use Notadd\Foundation\Editor\Controllers\UEditorController;
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
        $this->router->group(['middleware' => ['web']], function () {
            $this->router->any('editor', UEditorController::class . '@handle');
        });
    }
}
