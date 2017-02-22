<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-18 19:03
 */
namespace Notadd\Foundation\Module\Controllers;

use Notadd\Foundation\Module\Handlers\EnableHandler;
use Notadd\Foundation\Module\Handlers\ModuleHandler;

/**
 * Class ModuleController.
 */
class ModuleController
{
    /**
     * Enable handler.
     *
     * @param \Notadd\Foundation\Module\Handlers\EnableHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function enable(EnableHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Handler.
     *
     * @param \Notadd\Foundation\Module\Handlers\ModuleHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function handle(ModuleHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
