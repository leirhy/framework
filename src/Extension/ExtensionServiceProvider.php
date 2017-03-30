<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:06
 */
namespace Notadd\Foundation\Extension;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Extension\Commands\ListCommand;
use Notadd\Foundation\Extension\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Extension\Listeners\RouteRegister;

/**
 * Class ExtensionServiceProvider.
 */
class ExtensionServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * ExtensionServiceProvider constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->files = $app->make(Filesystem::class);
    }

    /**
     * Boot service provider.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
        $this->app->make(ExtensionManager::class)->getExtensions()->each(function (Extension $extension) {
            $path = $extension->getDirectory();
            if ($this->files->isDirectory($path) && is_string($extension->getEntry())) {
                $extension->isEnabled() && $this->app->register($extension->getEntry());
            }
        });
        $this->commands([
            ListCommand::class,
        ]);
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('extension', function ($app) {
            return new ExtensionManager($app, $app['events'], $app['files']);
        });
    }
}
