<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 19:03
 */
namespace Notadd\Foundation\SearchEngine\Apis;

use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

class SeoApi extends Controller
{
    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse       $response
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(ApiResponse $response, SettingsRepository $settings)
    {
        $settings->set('seo.description', $this->request->get('description'));
        $settings->set('seo.keyword', $this->request->get('keyword'));
        $settings->set('seo.title', $this->request->get('title'));
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }
}
