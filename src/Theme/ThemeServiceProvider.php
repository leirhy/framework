<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-15 17:49
 */
namespace Notadd\Foundation\Theme;

use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class ThemeServiceProvider.
 */
class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
    }

    /**
     * Register service provider.
     */
    public function register()
    {
        $this->app->singleton('theme', function ($app) {
            return new ThemeManager($app, $app['events'], $app['files']);
        });
    }
}
