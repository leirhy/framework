<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-01 14:58
 */
namespace Notadd\Foundation\Configuration;

use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Configuration\Loaders\FileLoader;

/**
 * Class ConfigServiceProvider.
 */
class ConfigServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('config', function ($app) {
            return new Repository($this->getConfigLoader(), $app['env']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['config'];
    }

    /**
     * TODO: Method getConfigLoader Description
     *
     * @return \Notadd\Foundation\Configuration\Loaders\FileLoader
     */
    public function getConfigLoader()
    {
        return new FileLoader($this->app['files'], $this->app['path'] . DIRECTORY_SEPARATOR . 'configurations');
    }
}
