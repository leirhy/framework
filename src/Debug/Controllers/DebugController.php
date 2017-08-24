<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-23 15:48
 */
namespace Notadd\Foundation\Debug\Controllers;

use Notadd\Foundation\Debug\Handlers\GetHandler;
use Notadd\Foundation\Debug\Handlers\PublishHandler;
use Notadd\Foundation\Debug\Handlers\SetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class DebugController.
 */
class DebugController extends Controller
{
    /**
     * @var array
     */
    protected $permissions = [
        'global::global::debug::debug.manage' => [
            'get',
            'set',
        ],
    ];

    /**
     * Get handler.
     *
     * @param GetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function get(GetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
    
    /**
     * set handler.
     *
     * @param \Notadd\Foundation\Debug\Handlers\SetHandler $handler
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function set(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
