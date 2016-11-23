<?php
/**
 * Created by PhpStorm.
 * User: TwilRoad
 * Date: 2016/11/16 0016
 * Time: 13:56.
 */
namespace Notadd\Foundation\Debug\Controllers;

use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class DebugApi.
 */
class DebugController extends Controller
{
    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse       $response
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(ApiResponse $response, SettingsRepository $settings)
    {
        $settings->set('debug.enabled', $this->request->input('enabled'));
        $response->withParams($settings->all()->toArray());

        return $response->generateHttpResponse();
    }
}
