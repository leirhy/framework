<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 12:21
 */
namespace Notadd\Foundation\Session\Commands;
use Carbon\Carbon;
use Illuminate\Session\Console\SessionTableCommand as IlluminateSessionTableCommand;
/**
 * Class SessionTableCommand
 * @package Notadd\Foundation\Session\Commands
 */
class SessionTableCommand extends IlluminateSessionTableCommand {
    /**
     * @return void
     */
    public function fire() {
        $fullPath = $this->createBaseMigration();
        $stub = $this->files->get($this->laravel->basePath() . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'sessions' . DIRECTORY_SEPARATOR . 'database.stub');
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        $this->files->put($fullPath, $stub);
        $this->info('Migration created successfully!');
        $this->composer->dumpAutoloads();
    }
}