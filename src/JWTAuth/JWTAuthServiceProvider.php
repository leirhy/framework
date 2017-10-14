<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-14 16:17
 */
namespace Notadd\Foundation\JWTAuth;

use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Tymon\JWTAuth\Blacklist;
use Tymon\JWTAuth\Claims\Factory;
use Tymon\JWTAuth\Commands\JWTGenerateCommand;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\JWTManager;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\Validators\PayloadValidator;

/**
 * Class JWTAuthServiceProvider.
 */
class JWTAuthServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'jwt.auth',
            'jwt.blacklist',
            'jwt.claim.factory',
            'jwt.generate',
            'jwt.manager',
            'jwt.payload.factory',
            'jwt.provider.auth',
            'jwt.provider.jwt',
            'jwt.provider.storage',
            'jwt.provider.user',
            'jwt.validators.payload',
        ];
    }

    /**
     * Register Service Provider.
     */
    public function register()
    {
        $this->app->singleton('jwt.provider.user', function (Application $app) {
            $provider = $app['config']['jwt.providers.user'];
            $model = $app->make($app['config']['jwt.user']);

            return new $provider($model);
        });
        $this->app->singleton('jwt.provider.jwt', function ($app) {
            $secret = $app['config']['jwt.secret'];
            $algo = $app['config']['jwt.algo'];
            $provider = $app['config']['jwt.providers.jwt'];

            return new $provider($secret, $algo);
        });
        $this->app->singleton('jwt.provider.auth', function ($app) {
            return $this->getConfigInstance($app['config']['jwt.providers.auth']);
        });
        $this->app->singleton('jwt.provider.storage', function ($app) {
            return $this->getConfigInstance($app['config']['jwt.providers.storage']);
        });
        $this->app->singleton('jwt.claim.factory', function () {
            return new Factory();
        });
        $this->app->singleton('jwt.manager', function ($app) {
            $instance = new JWTManager(
                $app['jwt.provider.jwt'],
                $app['jwt.blacklist'],
                $app['jwt.payload.factory']
            );

            return $instance->setBlacklistEnabled((bool)$app['config']['jwt.blacklist_enabled']);
        });
        $this->app->singleton('jwt.auth', function ($app) {
            $auth = new JWTAuth(
                $app['jwt.manager'],
                $app['jwt.provider.user'],
                $app['jwt.provider.auth'],
                $app['request']
            );

            return $auth->setIdentifier($app['config']['jwt.identifier']);
        });
        $this->app->singleton('jwt.blacklist', function ($app) {
            $instance = new Blacklist($app['jwt.provider.storage']);

            return $instance->setRefreshTTL($app['config']['jwt.refresh_ttl']);
        });
        $this->app->singleton('jwt.validators.payload', function ($app) {
            return with(new PayloadValidator())
                ->setRefreshTTL($app['config']['jwt.refresh_ttl'])
                ->setRequiredClaims($app['config']['jwt.required_claims']);
        });
        $this->app->singleton('jwt.payload.factory', function ($app) {
            $factory = new PayloadFactory(
                $app['jwt.claim.factory'],
                $app['request'],
                $app['jwt.validators.payload']
            );

            return $factory->setTTL($app['config']['jwt.ttl']);
        });
        $this->app->singleton('jwt.generate', function () {
            return new JWTGenerateCommand();
        });
    }

    /**
     * Get an instantiable configuration instance. Pinched from dingo/api :).
     *
     * @param mixed $instance
     *
     * @return object
     */
    protected function getConfigInstance($instance)
    {
        if (is_callable($instance)) {
            return call_user_func($instance, $this->app);
        } else if (is_string($instance)) {
            return $this->app->make($instance);
        }

        return $instance;
    }
}
