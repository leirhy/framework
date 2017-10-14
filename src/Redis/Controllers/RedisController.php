<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-09 23:50
 */
namespace Notadd\Foundation\Redis\Controllers;

use Notadd\Foundation\Redis\Handlers\ClearHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class RedisController.
 */
class RedisController extends Controller
{
    /**
     * @param \Notadd\Foundation\Redis\Handlers\ClearHandler $handler
     *
     * @return \Notadd\Foundation\Routing\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function clear(ClearHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
