<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 15:48
 */
namespace Notadd\Foundation\Debug\Controllers;

use Notadd\Foundation\Debug\Handlers\SetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class DebugController.
 */
class DebugController extends Controller
{
    /**
     * Api handler.
     *
     * @param \Notadd\Foundation\Debug\Handlers\SetHandler $handler
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function handle(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
