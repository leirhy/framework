<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 18:03
 */
namespace Notadd\Foundation\Mail\Controllers;

use Notadd\Foundation\Mail\Handlers\SetHandler;
use Notadd\Foundation\Mail\Handlers\TestHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class MailController.
 */
class MailController extends Controller
{
    /**
     * Api handler.
     *
     * @param \Notadd\Foundation\Mail\Handlers\SetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function handle(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Test Handler.
     *
     * @param \Notadd\Foundation\Mail\Handlers\TestHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function test(TestHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
