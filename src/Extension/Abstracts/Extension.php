<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-16 19:07
 */
namespace Notadd\Foundation\Extension\Abstracts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Class Extension.
 */
class Extension extends ServiceProvider
{
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Extension constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Events\Dispatcher                $events
     * @param \Illuminate\Routing\Router                   $router
     */
    public function __construct(Application $app, Dispatcher $events, Router $router)
    {
        parent::__construct($app);
        $this->events = $events;
        $this->router = $router;
    }

    /**
     * Boot extension.
     */
    public function boot() {
    }

    /**
     * Register extension extra providers.
     */
    public function register()
    {
    }
}
