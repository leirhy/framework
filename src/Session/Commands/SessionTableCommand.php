<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-22 12:21
 */
namespace Notadd\Foundation\Session\Commands;

use Carbon\Carbon;
use Illuminate\Session\Console\SessionTableCommand as IlluminateSessionTableCommand;

/**
 * Class SessionTableCommand.
 */
class SessionTableCommand extends IlluminateSessionTableCommand
{
    /**
     * Command handler.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $fullPath = $this->createBaseMigration();
        $stub = $this->files->get($this->getStub());
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        $this->files->put($fullPath, $stub);
        $this->info('Migration created successfully!');
        $this->composer->dumpAutoloads();
    }

    /**
     * Get stub file.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../stubs/sessions/database.stub';
    }
}
