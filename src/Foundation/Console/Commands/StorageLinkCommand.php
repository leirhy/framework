<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:22
 */
namespace Notadd\Foundation\Console\Commands;
use Illuminate\Console\Command;
/**
 * Class StorageLinkCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class StorageLinkCommand extends Command {
    /**
     * @var string
     */
    protected $signature = 'storage:link';
    /**
     * @var string
     */
    protected $description = 'Create a symbolic link from "public/storage" to "storage/app/public"';
    /**
     * @return void
     */
    public function fire() {
        if(file_exists(public_path('storage'))) {
            return $this->error('The "public/storage" directory already exists.');
        }
        $this->laravel->make('files')->link(storage_path('app/public'), public_path('storage'));
        $this->info('The [public/storage] directory has been linked.');
    }
}