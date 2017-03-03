<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-03 15:12
 */
namespace Notadd\Foundation\Module\Abstracts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class Module.
 */
abstract class Module extends ServiceProvider
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
     * Module constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->events = $app['events'];
        $this->router = $app['router'];
    }

    /**
     * Boot module.
     */
    abstract public function boot();

    /**
     * Install module.
     *
     * @return bool
     */
    abstract public function install();

    /**
     * Register module extra providers.
     */
    public function register()
    {
    }

    /**
     * Uninstall module.
     *
     * @return mixed
     */
    abstract public function uninstall();
}
