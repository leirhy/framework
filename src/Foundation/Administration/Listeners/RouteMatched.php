<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-31 10:56
 */
namespace Notadd\Foundation\Administration\Listeners;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Events\RouteMatched as RouteMatchedEvent;
use Notadd\Foundation\Administration\Administration;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;

/**
 * Class RouteMatched.
 */
class RouteMatched extends EventSubscriber
{
    /**
     * @var \Notadd\Foundation\Administration\Administration
     */
    protected $administration;

    /**
     * RouteMatched constructor.
     *
     * @param \Notadd\Foundation\Administration\Administration $administration
     * @param \Illuminate\Container\Container                  $container
     * @param \Illuminate\Events\Dispatcher                    $events
     */
    public function __construct(Administration $administration, Container $container, Dispatcher $events)
    {
        parent::__construct($container, $events);
        $this->administration = $administration;
    }

    /**
     * Name of event.
     *
     * @return mixed
     */
    protected function getEvent()
    {
        return RouteMatchedEvent::class;
    }

    /**
     * TODO: Method handle Description
     */
    public function handle()
    {
        if ($this->container->isInstalled() && !$this->container->runningInConsole()) {
        }
    }
}
