<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-15 17:49
 */
namespace Notadd\Foundation\Theme;

use Illuminate\Support\ServiceProvider;

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
