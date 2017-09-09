<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2017-09-09 23:43
 */
namespace Notadd\Foundation\Redis;

use Illuminate\Events\Dispatcher;
use Illuminate\Redis\RedisServiceProvider as IlluminateRedisServiceProvider;
use Notadd\Foundation\Redis\Listeners\RouteRegister;

/**
 * Class RedisServiceProvider.
 */
class RedisServiceProvider extends IlluminateRedisServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
    }
}
