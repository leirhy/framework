<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-04 10:48
 */
namespace Notadd\Foundation\SearchEngine;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\SearchEngine\Listeners\RouterRegistrar;

/**
 * Class SearchEngineServiceProvider.
 */
class SearchEngineServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * @return void
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouterRegistrar::class);
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('searchengine.optimization', function ($application) {
            return new Optimization($application, $application['setting'], $application['view']);
        });
    }
}
