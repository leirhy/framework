<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 15:07
 */
namespace Notadd\Foundation\Queue;
use Illuminate\Queue\QueueServiceProvider as IlluminateQueueServiceProvider;
/**
 * Class QueueServiceProvider
 * @package Notadd\Foundation\Queue
 */
class QueueServiceProvider extends IlluminateQueueServiceProvider {
    /**
     * @var bool
     */
    protected $defer = true;
}