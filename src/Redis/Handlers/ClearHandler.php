<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-09 23:51
 */
namespace Notadd\Foundation\Redis\Handlers;

use Illuminate\Container\Container;
use Illuminate\Redis\RedisManager;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class ClearHandler.
 */
class ClearHandler extends Handler
{
    /**
     * @var \Illuminate\Redis\RedisManager
     */
    protected $redis;

    /**
     * ClearHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Redis\RedisManager  $redis
     */
    public function __construct(Container $container, RedisManager $redis)
    {
        parent::__construct($container);
        $this->redis = $redis;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->redis->flushall();
        $this->withCode(200)->withMessage('Redis 缓存清除成功！');
    }
}
