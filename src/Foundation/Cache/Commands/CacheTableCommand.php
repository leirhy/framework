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
     * Command handler.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();
        $stub = $this->files->get($this->getStubPath());
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        $this->files->put($fullPath, $stub);
        $this->info('Migration created successfully!');
        $this->composer->dumpAutoloads();
    }

    /**
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../../stubs/caches/database.stub';
    }
}
