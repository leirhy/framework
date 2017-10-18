<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-18 18:07
 */
namespace Notadd\Foundation\Redis\Queues;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Notadd\Foundation\Bus\Dispatchable;

/**
 * Class FlushAll.
 */
class FlushAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Handle Queue.
     */
    public function handle()
    {
        app('redis')->flushall();
    }
}
