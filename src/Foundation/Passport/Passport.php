<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-22 15:55
 */
namespace Notadd\Foundation\Passport;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

/**
 * Class Passport.
 */
class Passport
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * Passport constructor.
     *
     * @param \Illuminate\Container\Container|\Notadd\Foundation\Application $container
     * @param \Illuminate\Events\Dispatcher                                  $events
     */
    public function __construct(Container $container, Dispatcher $events)
    {
        $this->container = $container;
        $this->events = $events;
    }

    /**
     * @return mixed
     * TODO: Method call Description
     *
     */
    public function call()
    {
        return true;
    }
}
