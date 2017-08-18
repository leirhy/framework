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
use Notadd\Foundation\SearchEngine\Handlers\HandlerHandler;

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
     * Api handler.
     *
     * @param \Notadd\Foundation\SearchEngine\Handlers\HandlerHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function handler(HandlerHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
