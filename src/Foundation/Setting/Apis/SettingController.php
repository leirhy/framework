<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-08 17:01
 */
namespace Notadd\Foundation\Setting\Apis;

use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class ApiController.
 */
class SettingController extends Controller
{
    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse       $response
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function all(ApiResponse $response, SettingsRepository $settings)
    {
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }

    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse       $response
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function set(ApiResponse $response, SettingsRepository $settings)
    {
        $settings->set('site.enabled', $this->request->input('enabled'));
        $settings->set('site.name', $this->request->input('name'));
        $settings->set('site.domain', $this->request->input('domain'));
        $settings->set('site.beian', $this->request->input('beian'));
        $settings->set('site.company', $this->request->input('company'));
        $settings->set('site.copyright', $this->request->input('copyright'));
        $settings->set('site.statistics', $this->request->input('statistics'));
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }
}
