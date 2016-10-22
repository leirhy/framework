<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 13:24
 */
namespace Notadd\Admin;
use Illuminate\Support\ServiceProvider;
use Notadd\Admin\Listeners\RouteRegistrar;
/**
 * Class AdminServiceProvider
 * @package Notadd\Admin
 */
class AdminServiceProvider extends ServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->app->make('events')->subscribe(RouteRegistrar::class);
    }
    /**
     * @return void
     */
    public function register() {
    }
}