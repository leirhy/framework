<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-22 17:50
 */
namespace Notadd\Foundation\Addon\Controllers;

use Notadd\Foundation\Addon\Handlers\EnableHandler;
use Notadd\Foundation\Addon\Handlers\ExportsHandler;
use Notadd\Foundation\Addon\Handlers\AddonHandler;
use Notadd\Foundation\Addon\Handlers\ImportsHandler;
use Notadd\Foundation\Addon\Handlers\InstallHandler;
use Notadd\Foundation\Addon\Handlers\UninstallHandler;
use Notadd\Foundation\Addon\Handlers\UpdateHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ExtensionController.
 */
class AddonController extends Controller
{
    /**
     * @var array
     */
    protected $permissions = [
        'global::global::extension::extension.manage' => [
            'enable',
            'handle',
            'install',
            'uninstall',
            'update',
        ],
    ];

    /**
     * Enable handler.
     *
     * @param \Notadd\Foundation\Addon\Handlers\EnableHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function enable(EnableHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Foundation\Addon\Handlers\ExportsHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function exports(ExportsHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Handler.
     *
     * @param \Notadd\Foundation\Addon\Handlers\AddonHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function handle(AddonHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Foundation\Addon\Handlers\ImportsHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function imports(ImportsHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Install handler.
     *
     * @param \Notadd\Foundation\Addon\Handlers\InstallHandler $handler
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
     * @param \Notadd\Foundation\Addon\Handlers\UninstallHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function uninstall(UninstallHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Update handler.
     *
     * @param \Notadd\Foundation\Addon\Handlers\UpdateHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function update(UpdateHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
