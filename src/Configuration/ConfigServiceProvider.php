<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-01 14:58
 */
namespace Notadd\Foundation\Configuration;

use Notadd\Foundation\Configuration\Loaders\FileLoader;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

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
     * Get config loader.
     *
     * @return \Notadd\Foundation\Configuration\Loaders\FileLoader
     */
    public function getConfigLoader()
    {
        return new FileLoader($this->app['files'], $this->app['path'] . DIRECTORY_SEPARATOR . 'configurations');
    }
}
