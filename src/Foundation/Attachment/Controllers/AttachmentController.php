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
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class AttachmentApi.
 */
class AttachmentController extends Controller
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * WatermarkController constructor.
     *
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(SettingsRepository $settings)
    {
        parent::__construct();
        $this->settings = $settings;
    }

    /**
     * TODO: Method handle Description
     *
     * @param \Notadd\Foundation\Attachment\Handlers\AttachmentSetHandler $handler
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(AttachmentSetHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}
