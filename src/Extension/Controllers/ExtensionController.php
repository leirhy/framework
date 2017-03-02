<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-22 17:50
 */
namespace Notadd\Foundation\Extension\Controllers;

use Notadd\Foundation\Extension\Handlers\EnableHandler;
use Notadd\Foundation\Extension\Handlers\ExtensionHandler;
use Notadd\Foundation\Extension\Handlers\InstallHandler;
use Notadd\Foundation\Extension\Handlers\UninstallHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ExtensionController.
 */
class ExtensionController extends Controller
{
    /**
     * Enable handler.
     *
     * @param \Notadd\Foundation\Extension\Handlers\EnableHandler $handler
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
     * @param \Notadd\Foundation\Extension\Handlers\ExtensionHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function handle(ExtensionHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Install handler.
     *
     * @param \Notadd\Foundation\Extension\Handlers\InstallHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function install(InstallHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Uninstall handler.
     *
     * @param \Notadd\Foundation\Extension\Handlers\UninstallHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function uninstall(UninstallHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
