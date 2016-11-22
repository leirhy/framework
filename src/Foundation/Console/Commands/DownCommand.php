<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:09
 */
namespace Notadd\Foundation\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class DownCommand.
 */
class DownCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'down {--message= : The message for the maintenance mode. }
            {--retry= : The number of seconds after which the request may be retried.}';
    /**
     * @var string
     */
    protected $description = 'Put the application into maintenance mode';

    /**
     * @return void
     */
    public function fire()
    {
        file_put_contents($this->laravel->storagePath() . '/bootstraps/down',
            json_encode($this->getDownFilePayload(), JSON_PRETTY_PRINT));
        $this->comment('Application is now in maintenance mode.');
    }

    /**
     * @return array
     */
    protected function getDownFilePayload()
    {
        return [
            'time' => Carbon::now()->getTimestamp(),
            'message' => $this->option('message'),
            'retry' => $this->getRetryTime(),
        ];
    }

    /**
     * @return int|null
     */
    protected function getRetryTime()
    {
        $retry = $this->option('retry');

        return is_numeric($retry) && $retry > 0 ? (int)$retry : null;
    }
}
