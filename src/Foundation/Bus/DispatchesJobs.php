<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:35
 */
namespace Notadd\Foundation\Bus;
use Illuminate\Contracts\Bus\Dispatcher;
/**
 * Class DispatchesJobs
 * @package Notadd\Foundation\Bus
 */
trait DispatchesJobs {
    /**
     * @param mixed $job
     * @return mixed
     */
    protected function dispatch($job) {
        return app(Dispatcher::class)->dispatch($job);
    }
    /**
     * @param mixed $job
     * @return mixed
     */
    public function dispatchNow($job) {
        return app(Dispatcher::class)->dispatchNow($job);
    }
}