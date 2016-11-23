<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-08 17:01
 */
namespace Notadd\Foundation\Setting\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Foundation\Setting\Handlers\AllHandler;
use Notadd\Foundation\Setting\Handlers\SetHandler;

/**
 * Class ApiController.
 */
class SettingController extends Controller
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * SettingController constructor.
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
    public function all()
    {
        $handler = new AllHandler($this->container, $this->settings);
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function set()
    {
        $handler = new SetHandler($this->container, $this->settings);
        $response = $handler->toResponse($this->request);

        return $response->generateHttpResponse();
    }
}
