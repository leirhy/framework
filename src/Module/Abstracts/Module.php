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
     * Description of module
     *
     * @return string
     */
    abstract public static function description();

    /**
     * Install for module.
     *
     * @return string
     */
    abstract public static function install();

    /**
     * Name of module.
     *
     * @return string
     */
    abstract public static function name();

    /**
     * Register module extra providers.
     */
    public function register()
    {
    }

    /**
     * Uninstall for module.
     *
     * @return string
     */
    abstract public static function uninstall();

    /**
     * Version of module.
     *
     * @return string
     */
    abstract public static function version();
}
