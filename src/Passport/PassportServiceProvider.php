<?php
/**
 * This file is part of Notadd.
 *
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
 * Class PassportServiceProvider.
 */
class PassportServiceProvider extends LaravelPassportServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouterRegistrar::class);
        $this->commands([
            ClientCommand::class,
            InstallCommand::class,
            KeysCommand::class,
        ]);
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        Passport::cookie('notadd_token');
        $this->registerAuthorizationServer();
        $this->registerResourceServer();
        $this->registerGuard();
        $this->app->singleton('api', function ($app) {
            return new Passport($app, $app['events']);
        });
    }

    /**
     * Register the token guard.
     *
     * @return void
     */
    protected function registerGuard()
    {
        $this->app['auth']->extend('passport', function ($app, $name, array $config) {
            return tap($this->makeGuard($config), function ($guard) {
                $this->app->refresh('request', $guard, 'setRequest');
            });
        });
    }
}
