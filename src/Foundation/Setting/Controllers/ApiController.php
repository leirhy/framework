<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-08 17:01
 */
namespace Notadd\Foundation\Setting\Controllers;
use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Routing\Abstracts\Controller;
/**
 * Class ApiController
 * @package Notadd\Foundation\Setting\Controllers
 */
class ApiController extends Controller {
    /**
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse $response
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function all(ApiResponse $response) {
        $response->withParams($this->getSetting()->all()->toArray());
        return $response->generateHttpResponse();
    }
}