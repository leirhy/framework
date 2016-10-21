<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:10
 */
namespace Notadd\Foundation\Routing\Events;
use Illuminate\Container\Container;
use Illuminate\Routing\Router;
/**
 * Class RouteRegister
 * @package Notadd\Foundation\Routing\Events
 */
class RouteRegister {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * RouteRegister constructor.
     * @param \Illuminate\Contracts\Foundation\Application|\Illuminate\Container\Container $container
     * @param \Illuminate\Routing\Router $router
     */
    public function __construct(Container $container, Router $router) {
        $this->container = $container;
        $this->router = $router;
    }
}