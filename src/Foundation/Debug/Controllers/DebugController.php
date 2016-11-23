<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 15:48
 */
namespace Notadd\Foundation\Debug\Controllers;

use Notadd\Foundation\Debug\Handlers\SetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class DebugApi.
 */
class DebugController extends Controller
{
    /**
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(SettingsRepository $settings)
    {
        $handler = new SetHandler($this->container, $settings);
        $response = $handler->toResponse($this->request);

        return $response->generateHttpResponse();
    }
}
