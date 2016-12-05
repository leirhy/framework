<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 15:24
 */
namespace Notadd\Foundation\Routing\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Str;
use Notadd\Foundation\Validation\ValidatesRequests;

/**
 * Class Controller.
 */
abstract class Controller extends IlluminateController
{
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
    public function __construct()
    {
        $this->container = $this->getContainer();
        $this->events = $this->container->make('events');
        $this->redirector = $this->container->make('redirect');
        $this->request = $this->container->make('request');
        $this->view = $this->container->make('view');
    }

    /**
     * TODO: Method getCommand Description
     *
     * @param string $name
     *
     * @return \Symfony\Component\Console\Command\Command|\Notadd\Foundation\Console\Abstracts\Command
     */
    public function getCommand($name)
    {
        return $this->getConsole()->get($name);
    }

    /**
     * TODO: Method getConfig Description
     *
     * @return \Notadd\Foundation\Configuration\Repository
     */
    public function getConfig()
    {
        return $this->container->make('config');
    }

    /**
     * TODO: Method getConsole Description
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
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
     * TODO: Method getLogger Description
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger()
    {
        return $this->container->make('log');
    }

    /**
     * TODO: Method getMailer Description
     *
     * @return \Illuminate\Mail\Mailer
     */
    public function getMailer()
    {
        return $this->container->make('mailer');
    }

    /**
     * TODO: Method getSession Description
     *
     * @return \Illuminate\Session\Store
     */
    public function getSession()
    {
        return $this->container->make('session');
    }

    /**
     * TODO: Method getSetting Description
     *
     * @return \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    public function getSetting()
    {
        return $this->container->make('setting');
    }

    /**
     * TODO: Method share Description
     *
     * @param      $key
     * @param null $value
     */
    protected function share($key, $value = null)
    {
        $this->view->share($key, $value);
    }

    /**
     * TODO: Method view Description
     *
     * @param       $template
     * @param array $data
     * @param array $mergeData
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function view($template, array $data = [], $mergeData = [])
    {
        if (Str::contains($template, '::')) {
            return $this->view->make($template, $data, $mergeData);
        } else {
            return $this->view->make('theme::' . $template, $data, $mergeData);
        }
    }
}
