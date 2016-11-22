<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 10:44
 */
namespace Notadd\Foundation\Extension\Abstracts;

use Illuminate\Container\Container;
use Notadd\Foundation\Extension\Extension;

/**
 * Class ExtensionRegistrar.
 */
abstract class ExtensionRegistrar
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
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $setting;
    /**
     * @var \Illuminate\Support\ServiceProvider
     */
    protected $provider;

    /**
     * ExtensionRegistrar constructor.
     */
    public function __construct()
    {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
        $this->router = $this->container->make('router');
        $this->setting = $this->container->make('setting');
    }

    /**
     * @param string       $abstract
     * @param array|string $alias
     */
    public function alias($abstract, $alias)
    {
        foreach ((array)$alias as $item) {
            $this->container->alias($abstract, $item);
        }
    }

    /**
     * @return array
     */
    public function compiles()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function environment()
    {
        return true;
    }

    /**
     * @return \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected function getContainer()
    {
        return Container::getInstance();
    }

    /**
     * @return \Notadd\Foundation\Extension\Extension
     */
    final public function getExtension()
    {
        $extension = new Extension($this->getExtensionName(), $this->getExtensionPath());
        $extension->setRegistrar($this);

        return $extension;
    }

    /**
     * @return array
     */
    abstract public function getExtensionInfo();

    /**
     * @return string
     */
    abstract public function getExtensionName();

    /**
     * @return string
     */
    abstract public function getExtensionPath();

    /**
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * @return array
     */
    public function loadCommands()
    {
        return [];
    }

    /**
     * @return array
     */
    public function loadLocalizationsFrom()
    {
        return [];
    }

    /**
     * @return array
     */
    public function loadMigrationsFrom()
    {
        return [];
    }

    /**
     * @return array
     */
    public function loadPublishesFrom()
    {
        return [];
    }

    /**
     * @return array
     */
    public function loadViewsFrom()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}
