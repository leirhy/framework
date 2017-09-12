<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-18 19:03
 */
namespace Notadd\Foundation\SearchEngine\Controllers;

use Notadd\Foundation\Routing\Abstracts\ApiController;
use Notadd\Foundation\SearchEngine\Handlers\CreateHandler;
use Notadd\Foundation\SearchEngine\Handlers\ListHandler;
use Notadd\Foundation\SearchEngine\Handlers\ModuleHandler;

/**
 * Class SeoController.
 */
class SeoController extends ApiController
{
    /**
     * @var array
     */
    protected $permissions = [
        'global::global::search-engine::seo.set' => 'set',
    ];

    /**
     * @param \Notadd\Foundation\SearchEngine\Handlers\CreateHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function create(CreateHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Foundation\SearchEngine\Handlers\ListHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function list(ListHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Foundation\SearchEngine\Handlers\ModuleHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function module(ModuleHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
