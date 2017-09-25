<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-25 13:42
 */
namespace Notadd\Foundation\Routing\Traits;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;

/**
 * Class Helpers.
 *
 * @property \Illuminate\Container\Container|\Notadd\Foundation\Application $container
 * @property \Illuminate\Http\Request                                       $request
 * @property \Illuminate\Routing\Redirector                                 $redirector
 * @property \Illuminate\Session\Store                                      $session
 * @property \Notadd\Foundation\Setting\Contracts\SettingsRepository        $setting
 * @property \Psr\Log\LoggerInterface                                       $log
 * @property \Illuminate\Contracts\Routing\ResponseFactory                  $response
 */
trait Helpers
{
    /**
     * Get configuration instance.
     *
     * @return \Illuminate\Contracts\Config\Repository
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getConfig()
    {
        return Container::getInstance()->make('config');
    }

    /**
     * Get console instance.
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getConsole()
    {
        $kernel = Container::getInstance()->make(Kernel::class);
        $kernel->bootstrap();

        return $kernel->getArtisan();
    }

    /**
     * Get IoC Container.
     *
     * @return \Illuminate\Container\Container
     */
    protected function getContainer(): Container
    {
        return Container::getInstance();
    }

    /**
     * Get mailer instance.
     *
     * @return \Illuminate\Mail\Mailer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getMailer(): Mailer
    {
        return Container::getInstance()->make('mailer');
    }

    /**
     * Get session instance.
     *
     * @return \Illuminate\Session\SessionManager
     */
    protected function getSession(): SessionManager
    {
        return Container::getInstance()->make('session');
    }

    /**
     * @return \Illuminate\Http\Request
     */
    protected function getRequest(): Request
    {
        return Container::getInstance()->make('request');
    }

    /**
     * @return \Illuminate\Routing\Redirector
     */
    protected function getRedirector(): Redirector
    {
        return Container::getInstance()->make('redirect');
    }

    /**
     * @return \Illuminate\Events\Dispatcher
     */
    protected function getEvent(): Dispatcher
    {
        return Container::getInstance()->make('events');
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    protected function getLogger()
    {
        return Container::getInstance()->make('log');
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function getResponse()
    {
        return $this->container->make(ResponseFactory::class);
    }

    /**
     * Get setting instance.
     *
     * @return \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected function getSetting()
    {
        return $this->container->make('setting');
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($key)
    {
        $callable = [
            'config',
            'console',
            'container',
            'event',
            'log',
            'redirector',
            'request',
            'response',
            'session',
            'setting',
        ];
        if (in_array($key, $callable) && method_exists($this, 'get' . ucfirst($key))) {
            return $this->$key();
        }
        throw new Exception('Undefined property ' . get_class($this) . '::' . $key);
    }
}
