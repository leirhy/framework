<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:54
 */
namespace Notadd\Foundation\Console;
use Illuminate\Console\ScheduleServiceProvider;
use Illuminate\Database\SeedServiceProvider;
use Illuminate\Queue\ConsoleServiceProvider as QueueConsoleServiceProvider;
use Illuminate\Support\AggregateServiceProvider;
use Notadd\Foundation\Composer\ComposerServiceProvider;
use Notadd\Foundation\Database\MigrationServiceProvider;
/**
 * Class ConsoleServiceProvider
 * @package Notadd\Foundation\Providers
 */
class ConsoleServiceProvider extends AggregateServiceProvider {
    /**
     * @var bool
     */
    protected $defer = true;
    /**
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        ScheduleServiceProvider::class,
        MigrationServiceProvider::class,
        SeedServiceProvider::class,
        ComposerServiceProvider::class,
        QueueConsoleServiceProvider::class
    ];
}