<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 15:30
 */
namespace Notadd\Foundation\Routing\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Notadd\Foundation\Abstracts\EventSubscriber;
use Notadd\Foundation\Routing\Events\RouteRegister as RouteRegisterEvent;
/**
 * Class AbstractRouteRegister
 * @package Notadd\Foundation\Routing\Abstracts
 */
abstract class RouteRegistrar extends EventSubscriber {
    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * RouteRegistrar constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     * @param \Illuminate\Routing\Router $router
     */
    public function __construct(Container $container, Dispatcher $events, Router $router) {
        parent::__construct($container, $events);
        $this->router = $router;
    }
    /**
     * @return string
     */
    protected function getEvent() {
        return RouteRegisterEvent::class;
    }
    /**
     * @return void
     */
    abstract public function handle();
}