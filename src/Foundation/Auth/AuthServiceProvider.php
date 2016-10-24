<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:49
 */
namespace Notadd\Foundation\Auth;
use Illuminate\Auth\AuthServiceProvider as IlluminateAuthServiceProvider;
/**
 * Class AuthServiceProvider
 * @package Notadd\Foundation\Auth
 */
class AuthServiceProvider extends IlluminateAuthServiceProvider {
    /**
     * @return void
     */
    public function register() {
        parent::register();
    }
}