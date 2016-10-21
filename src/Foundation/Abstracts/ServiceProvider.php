<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 09:52
 */
namespace Notadd\Foundation\Abstracts;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
/**
 * Class ServiceProvider
 * @package Notadd\Foundation\Abstracts
 */
abstract class ServiceProvider extends IlluminateServiceProvider {
    /**
     * @var \Notadd\Foundation\Application
     */
    protected $app;
    /**
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $blade;
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;
    /**
     * ServiceProvider constructor.
     * @param \Notadd\Foundation\Application $application
     */
    public function __construct($application) {
        parent::__construct($application);
        $this->config = $this->app->make('config');
        $this->events = $this->app->make('events');
        $this->router = $this->app->make('router');
        $this->view = $this->app->make('view');
        $this->blade = $this->view->getEngineResolver()->resolve('blade')->getCompiler();
    }
    /**
     * @return void
     */
    public function boot() {
    }
    /**
     * @return void
     */
    public function register() {
    }
}