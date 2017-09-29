<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-26 15:06
 */
namespace Notadd\Foundation\Administration\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class InformationsController.
 */
class InformationsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->response->json([
            'data'    => [
                'navigation'  => $this->administration->navigations()->toArray(),
                'pages'       => $this->administration->pages()->toArray(),
                'scripts'     => $this->administration->scripts()->toArray(),
                'stylesheets' => $this->administration->stylesheets()->toArray(),
            ],
            'message' => '获取模块和插件信息成功！',
        ]);
    }
}
