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
 * @property \Notadd\Foundation\Addon\AddonManager                          $addon
 * @property \Notadd\Foundation\Administration\AdministrationManager        $administration
 * @property \Illuminate\Auth\AuthManager                                   $auth
 * @property \Illuminate\Cache\CacheManager                                 $cache
 * @property \Illuminate\Container\Container|\Notadd\Foundation\Application $container
 * @property \Illuminate\Database\Connection                                $db
 * @property \Notadd\Foundation\Extension\ExtensionManager                  $extension
 * @property \Illuminate\Filesystem\Filesystem                              $file
 * @property \Psr\Log\LoggerInterface                                       $log
 * @property \Notadd\Foundation\Module\ModuleManager                        $module
 * @property \Illuminate\Routing\Redirector                                 $redirector
 * @property \Illuminate\Http\Request                                       $request
 * @property \Illuminate\Contracts\Routing\ResponseFactory                  $response
 * @property \Illuminate\Session\Store                                      $session
 * @property \Notadd\Foundation\Setting\Contracts\SettingsRepository        $setting
 * @property \Notadd\Foundation\Translation\Translator                      $translator
 * @property \Illuminate\Routing\UrlGenerator                               $url
 */
trait Helpers
{
    /**
     * @return mixed|\Notadd\Foundation\Addon\AddonManager
     */
    protected function getAddon()
    {
        return $this->container->make('addon');
    }

    /**
     * @return \Notadd\Foundation\Administration\AdministrationManager
     */
    protected function getAdministration()
    {
        return $this->container->make('administration');
    }

    /**
     * @return \Illuminate\Auth\AuthManager
     */
    protected function getAuth()
    {
        return $this->container->make('auth');
    }

    /**
     * Get configuration instance.
     *
     * @return \Illuminate\Contracts\Config\Repository
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getConfig()
    {
        return $this->container->make('config');
    }

    /**
     * @return \Illuminate\Database\DatabaseManager
     */
    protected function getDb()
    {
        return $this->container->make('db');
    }

    /**
     * Get console instance.
     *
     * @return \Illuminate\Contracts\Console\Kernel|\Notadd\Foundation\Console\Application
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getConsole()
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
    protected function getContainer(): Container
    {
        return Container::getInstance();
    }

    /**
     * @return \Notadd\Foundation\Extension\ExtensionManager
     */
    protected function getExtension()
    {
        return $this->container->make('extension');
    }

    /**
     * Get mailer instance.
     *
     * @return \Illuminate\Mail\Mailer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getMailer(): Mailer
    {
        return $this->container->make('mailer');
    }

    /**
     * @return \Notadd\Foundation\Module\ModuleManager
     */
    protected function getModule()
    {
        return $this->container->make('module');
    }

    /**
     * Get session instance.
     *
     * @return \Illuminate\Session\SessionManager
     */
    protected function getSession(): SessionManager
    {
        return $this->container->make('session');
    }

    /**
     * @return \Illuminate\Http\Request
     */
    protected function getRequest(): Request
    {
        return $this->container->make('request');
    }

    /**
     * @return \Illuminate\Routing\Redirector
     */
    protected function getRedirector(): Redirector
    {
        return $this->container->make('redirect');
    }

    /**
     * @return \Illuminate\Events\Dispatcher
     */
    protected function getEvent(): Dispatcher
    {
        return $this->container->make('events');
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    protected function getLogger()
    {
        return $this->container->make('log');
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
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function getFile()
    {
        return $this->container->make('files');
    }

    /**
     * @return \Illuminate\Routing\UrlGenerator
     */
    protected function getUrl()
    {
        return $this->container->make('url');
    }

    /**
     * @return \Notadd\Foundation\Translation\Translator
     */
    protected function getTranslator()
    {
        return $this->container->make('translator');
    }

    /**
     * @return \Illuminate\Cache\CacheManager
     */
    protected function getCache()
    {
        return $this->container->make('cache');
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($key)
    {
        if (method_exists($this, 'get' . ucfirst($key))) {
            return $this->{'get' . ucfirst($key)}();
        }
        throw new Exception('Undefined property ' . get_class($this) . '::' . $key);
    }
}
