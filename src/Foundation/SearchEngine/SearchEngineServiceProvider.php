<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-04 10:48
 */
namespace Notadd\Foundation\SearchEngine;
use Illuminate\Support\ServiceProvider;
/**
 * Class SearchEngineServiceProvider
 * @package Notadd\Foundation\SearchEngine
 */
class SearchEngineServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('searchengine.optimization', function($application) {
            return new Optimization($application, $application['setting'], $application['view']);
        });
    }
}