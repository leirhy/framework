<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 13:18
 */
namespace Notadd\Foundation\Composer;
use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;
/**
 * Class ComposerServiceProvider
 * @package Notadd\Foundation\Providers
 */
class ComposerServiceProvider extends ServiceProvider {
    /**
     * @var bool
     */
    protected $defer = true;
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('composer', function ($app) {
            return new Composer($app['files'], $app->basePath());
        });
    }
    /**
     * @return array
     */
    public function provides() {
        return ['composer'];
    }
}