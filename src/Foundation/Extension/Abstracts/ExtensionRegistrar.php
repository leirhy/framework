<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 10:44
 */
namespace Notadd\Foundation\Extension\Abstracts;
use Illuminate\Container\Container;
use Notadd\Foundation\Extension\Extension;
/**
 * Class ExtensionRegistrar
 * @package Notadd\Extension\Abstracts
 */
abstract class ExtensionRegistrar {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var \Illuminate\Support\ServiceProvider
     */
    protected $provider;
    /**
     * ExtensionRegistrar constructor.
     */
    public function __construct() {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
    }
    /**
     * @return array
     */
    public function compiles() {
        return [];
    }
    /**
     * @return \Illuminate\Container\Container
     */
    protected function getContainer() {
        return Container::getInstance();
    }
    /**
     * @return \Notadd\Foundation\Extension\Extension
     */
    final public function getExtension() {
        $extension = new Extension($this->getExtensionName(), $this->getExtensionPath());
        $extension->setRegistrar($this);
        return $extension;
    }
    /**
     * @return string
     */
    abstract protected function getExtensionName();
    /**
     * @return string
     */
    abstract protected function getExtensionPath();
    /**
     * @return array
     */
    public function loadLocalizationsFrom() {
        return [];
    }
    /**
     * @return array
     */
    public function loadMigrationsFrom() {
        return [];
    }
    /**
     * @return array
     */
    public function loadViewsFrom() {
        return [];
    }
    /**
     * @return void
     */
    abstract public function register();
}