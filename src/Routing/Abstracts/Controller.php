<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 15:24
 */
namespace Notadd\Foundation\Routing\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Routing\Controller as IlluminateController;
use Notadd\Foundation\Routing\Traits\Flowable;
use Notadd\Foundation\Routing\Traits\Logable;
use Notadd\Foundation\Routing\Traits\Settingable;
use Notadd\Foundation\Routing\Traits\Viewable;
use Notadd\Foundation\Validation\ValidatesRequests;

/**
 * Class Controller.
 */
abstract class Controller extends IlluminateController
{
    use Flowable, Logable, Settingable, ValidatesRequests, Viewable;

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
     * Controller constructor.
     */
    public function __construct()
    {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
        $this->redirector = $this->container->make('redirect');
        $this->request = $this->container->make('request');
    }

    /**
     * Get a command from console instance.
     *
     * @param string $name
     *
     * @return \Notadd\Foundation\Console\Abstracts\Command|\Symfony\Component\Console\Command\Command
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getCommand($name)
    {
        return $this->getConsole()->get($name);
    }

    /**
     * Get configuration instance.
     *
     * @return \Notadd\Foundation\Configuration\Repository
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getConfig()
    {
        return $this->container->make('config');
    }

    /**
     * Get console instance.
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getConsole()
    {
        $kernel = $this->container->make(Kernel::class);
        $kernel->bootstrap();

        return $kernel->getArtisan();
    }

    /**
     * Get IoC Container.
     *
     * @return \Illuminate\Container\Container
     */
    public function getContainer()
    {
        return Container::getInstance();
    }

    /**
     * Get mailer instance.
     *
     * @return \Illuminate\Mail\Mailer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getMailer()
    {
        return $this->container->make('mailer');
    }

    /**
     * Get session instance.
     *
     * @return \Illuminate\Session\Store
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getSession()
    {
        return $this->container->make('session');
    }
}
