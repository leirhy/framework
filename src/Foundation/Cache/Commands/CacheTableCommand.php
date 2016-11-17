<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 13:36
 */
namespace Notadd\Foundation\Cache\Commands;

use Carbon\Carbon;
use Illuminate\Cache\Console\CacheTableCommand as IlluminateCacheTableCommand;

/**
 * Class CacheTableCommand.
 */
class CacheTableCommand extends IlluminateCacheTableCommand
{
    /**
     * @return void
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();
        $stub = $this->files->get($this->laravel->basePath().DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'caches'.DIRECTORY_SEPARATOR.'database.stub');
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        $this->files->put($fullPath, $stub);
        $this->info('Migration created successfully!');
        $this->composer->dumpAutoloads();
    }
}
