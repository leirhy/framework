<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 13:09
 */
namespace Notadd\Foundation\Notification\Commands;

use Carbon\Carbon;
use Illuminate\Notifications\Console\NotificationTableCommand as IlluminateNotificationTableCommand;

/**
 * Class NotificationTableCommand.
 */
class NotificationTableCommand extends IlluminateNotificationTableCommand
{
    /**
     * Command handler.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function fire()
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
        return __DIR__ . '/../../../stubs/notifications/database.stub';
    }
}
