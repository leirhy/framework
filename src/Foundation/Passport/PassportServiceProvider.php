<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 17:21
 */
namespace Notadd\Foundation\Passport;
use Illuminate\Events\Dispatcher;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider as LaravelPassportServiceProvider;
use Notadd\Foundation\Passport\Listeners\RouterRegistrar;
/**
 * Class PassportServiceProvider
 * @package Notadd\Foundation\Passport
 */
class PassportServiceProvider extends LaravelPassportServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->app->make(Dispatcher::class)->subscribe(RouterRegistrar::class);
        $this->commands([
            ClientCommand::class,
            InstallCommand::class,
            KeysCommand::class,
        ]);
    }
    /**
     * @return void
     */
    public function register() {
        Passport::cookie('notadd_token');
        $this->registerAuthorizationServer();
        $this->registerResourceServer();
        $this->registerGuard();
    }
}