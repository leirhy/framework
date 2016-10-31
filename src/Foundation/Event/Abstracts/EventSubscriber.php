<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 15:34
 */
namespace Notadd\Foundation\Event\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Str;
/**
 * Class EventSubscriber
 * @package Notadd\Foundation\Abstracts
 */
abstract class EventSubscriber {
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * EventSubscriber constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function __construct(Container $container, Dispatcher $events) {
        $this->container = $container;
        $this->events = $events;
    }
    /**
     * @return string|object
     * @throws \Exception
     */
    protected function getEvent() {
        throw new \Exception('Event not found!', 404);
    }
    /**
     * @return void
     */
    public function subscribe() {
        $method = 'handle';
        if(method_exists($this, $getHandler = 'get' . Str::ucfirst($method) . 'r')) {
            $method = $this->{$getHandler}();
        }
        $this->events->listen($this->getEvent(), [
            $this,
            $method
        ]);
    }
}