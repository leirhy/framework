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
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

class MailController extends Controller
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
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle()
    {
        $handler = new SetHandler($this->container, $this->settings);
        $response = $handler->toResponse($this->request);

        return $response->generateHttpResponse();
    }
}
