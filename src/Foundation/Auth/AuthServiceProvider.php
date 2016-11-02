<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:49
 */
namespace Notadd\Foundation\Auth;
use Illuminate\Auth\AuthServiceProvider as IlluminateAuthServiceProvider;
use Illuminate\Routing\Router;
use Notadd\Foundation\Auth\Controllers\AuthController;
/**
 * Class AuthServiceProvider
 * @package Notadd\Foundation\Auth
 */
class AuthServiceProvider extends IlluminateAuthServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->app->make(Router::class)->group(['middleware' => 'web'], function() {
            $this->app->make(Router::class)->get('logout', AuthController::class . '@logout');
            $this->app->make(Router::class)->resource('login', AuthController::class);
        });
    }
    /**
     * @return void
     */
    public function register() {
        parent::register();
    }
}