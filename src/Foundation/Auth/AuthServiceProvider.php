<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:49
 */
namespace Notadd\Foundation\Auth;
use Illuminate\Auth\AuthServiceProvider as IlluminateAuthServiceProvider;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Auth\Listeners\RouteRegistrar;
/**
 * Class AuthServiceProvider
 * @package Notadd\Foundation\Auth
 */
class AuthServiceProvider extends IlluminateAuthServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->app->make(Dispatcher::class)->subscribe(RouteRegistrar::class);
    }
}