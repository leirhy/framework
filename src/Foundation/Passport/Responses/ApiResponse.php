<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-08 11:03
 */
namespace Notadd\Foundation\Passport\Responses;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
/**
 * Class ApiResponse
 * @package Notadd\Foundation\Passport\Responses
 */
class ApiResponse {
    /**
     * @var array
     */
    protected $params = [];
    /**
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response|static
     */
    public function generateHttpResponse(ResponseInterface $response = null, $params = []) {
        is_null($response) && $response = new Response();
        $params && $this->params = array_merge($this->params, $params);
        $response = $response->withStatus(200)
            ->withHeader('pragma', 'no-cache')
            ->withHeader('cache-control', 'no-store')
            ->withHeader('content-type', 'application/json; charset=UTF-8');
        $response->getBody()->write(json_encode($this->params));
        return $response;
    }
    /**
     * @param array $params
     */
    public function withParams($params = []) {
        $this->params = array_merge($this->params, $params);
    }
}