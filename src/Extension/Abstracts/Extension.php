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
use Illuminate\Support\ServiceProvider;

/**
 * Class Extension.
 */
abstract class Extension extends ServiceProvider
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
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->events = $app['events'];
        $this->router = $app['router'];
    }

    /**
     * Boot extension.
     */
    abstract public function boot();

    /**
     * Description of extension
     *
     * @return string
     */
    abstract public static function description();

    /**
     * Installer for extension.
     *
     * @return string
     */
    abstract public static function install();

    /**
     * Name of extension.
     *
     * @return string
     */
    abstract public static function name();

    /**
     * Register extension extra providers.
     */
    public function register()
    {
    }

    /**
     * Uninstall for extension.
     *
     * @return string
     */
    abstract public static function uninstall();
}
