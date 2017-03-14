<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 19:03
 */
namespace Notadd\Foundation\SearchEngine\Controllers;

use Notadd\Foundation\Routing\Abstracts\ApiController;
use Notadd\Foundation\SearchEngine\Handlers\SetHandler;

/**
 * Class SeoController.
 */
class SeoController extends ApiController
{
    /**
     * Api handler.
     *
     * @param \Notadd\Foundation\SearchEngine\Handlers\SetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function handle(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
