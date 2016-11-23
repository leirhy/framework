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
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class SeoController.
 */
class SeoController extends ApiController
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
