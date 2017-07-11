<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-16 19:07
 */
namespace Notadd\Foundation\Extension\Abstracts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

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
     * @var \Illuminate\Support\Collection
     */
    protected static $migrations;

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
        static::$migrations = new Collection();
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
     * @param array|string $paths
     */
    public function loadMigrationsFrom($paths)
    {
        static::$migrations = static::$migrations->merge((array)$paths);
        parent::loadMigrationsFrom($paths);
    }

    /**
     * @return array
     */
    public static function migrations()
    {
        return static::$migrations->toArray();
    }

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

    /**
     * Version of extension.
     *
     * @return string
     */
    abstract public static function version();
}
