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
use Notadd\Foundation\SearchEngine\Handlers\GetHandler;
use Notadd\Foundation\SearchEngine\Handlers\SetHandler;

/**
 * Class SeoController.
 */
class SeoController extends ApiController
{
    /**
     * @var array
     */
    protected $permissions = [
        'global::global::search-engine::seo.get' => 'get',
        'global::global::search-engine::seo.set' => 'set',
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
     * Api handler.
     *
     * @param \Notadd\Foundation\SearchEngine\Handlers\SetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function set(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
