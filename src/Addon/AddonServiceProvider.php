<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-08-29 14:06
 */
namespace Notadd\Foundation\Addon;

use Notadd\Foundation\Addon\AddonManager;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class ExtensionServiceProvider.
 */
class AddonServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @return array
     */
    public function provides()
    {
        return ['extension'];
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('extension', function ($app) {
            return new AddonManager($app, $app['config'], $app['events'], $app['files']);
        });
    }
}
