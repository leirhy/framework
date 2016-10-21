<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 13:03
 */
namespace Notadd\Foundation\Console\Commands;
use Illuminate\Console\Command;
/**
 * Class UpCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class UpCommand extends Command {
    /**
     * @var string
     */
    protected $name = 'up';
    /**
     * @var string
     */
    protected $description = 'Bring the application out of maintenance mode';
    /**
     * @return void
     */
    public function fire() {
        @unlink($this->laravel->storagePath() . '/framework/down');
        $this->info('Application is now live.');
    }
}