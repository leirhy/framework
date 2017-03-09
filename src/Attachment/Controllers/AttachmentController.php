<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-02 15:55
 */
namespace Notadd\Foundation\Attachment\Controllers;

use Notadd\Foundation\Attachment\Handlers\AttachmentSetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class AttachmentController.
 */
class AttachmentController extends Controller
{
    /**
     * Api handler.
     *
     * @param \Notadd\Foundation\Attachment\Handlers\AttachmentSetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function handle(AttachmentSetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
