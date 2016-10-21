<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 15:24
 */
namespace Notadd\Foundation\Routing\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Str;
use Notadd\Foundation\Validation\ValidatesRequests;
/**
 * Class Controller
 * @package Notadd\Foundation\Routing\Abstracts
 */
class Controller extends IlluminateController {
    use ValidatesRequests;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var array
     */
    protected $middleware = [];
    /**
     * @var \Illuminate\Routing\Redirector
     */
    protected $redirector;
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;
    /**
     * Controller constructor.
     */
    public function __construct() {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
        $this->redirector = $this->container->make('redirect');
        $this->request = $this->container->make('request');
        //$this->session = $this->request->session();
        $this->view = $this->container->make('view');
    }
    /**
     * @return \Illuminate\Config\Repository
     */
    public function getConfig() {
        return $this->container->make('config');
    }
    /**
     * @return \Illuminate\Container\Container
     */
    public function getContainer() {
        return Container::getInstance();
    }
    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() {
        return $this->container->make('log');
    }
    /**
     * @return \Illuminate\Mail\Mailer
     */
    public function getMailer() {
        return $this->container->make('mailer');
    }
    /**
     * @param $key
     * @param null $value
     */
    protected function share($key, $value = null) {
        $this->view->share($key, $value);
    }
    /**
     * @param $template
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    protected function view($template, array $data = [], $mergeData = []) {
        if(Str::contains($template, '::')) {
            return $this->view->make($template, $data, $mergeData);
        } else {
            return $this->view->make('theme::' . $template, $data, $mergeData);
        }
    }
}