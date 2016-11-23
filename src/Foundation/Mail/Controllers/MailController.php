<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-18 18:03
 */
namespace Notadd\Foundation\Mail\Controllers;

use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

class MailController extends Controller
{
    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse       $response
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(ApiResponse $response, SettingsRepository $settings)
    {
        $settings->set('mail.protocol', $this->request->input('protocol'));
        $settings->set('mail.encryption', $this->request->input('encryption'));
        $settings->set('mail.port', $this->request->input('port'));
        $settings->set('mail.host', $this->request->input('host'));
        $settings->set('mail.mail', $this->request->input('mail'));
        $settings->set('mail.username', $this->request->input('username'));
        $settings->set('mail.password', $this->request->input('password'));
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }
}
