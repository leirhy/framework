<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-18 20:33
 */
namespace Notadd\Foundation\Sitemap\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Sitemap\Handlers\SitemapHandler;

/**
 * Class SitemapController.
 */
class SitemapController extends Controller
{
    /**
     * Handler.
     *
     * @param \Notadd\Foundation\Sitemap\Handlers\SitemapHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function handle(SitemapHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
