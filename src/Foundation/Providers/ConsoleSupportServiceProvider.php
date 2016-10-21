<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:54
 */
namespace Notadd\Foundation\Providers;
use Illuminate\Console\ScheduleServiceProvider;
use Illuminate\Database\MigrationServiceProvider;
use Illuminate\Database\SeedServiceProvider;
use Illuminate\Queue\ConsoleServiceProvider;
use Illuminate\Support\AggregateServiceProvider;
/**
 * Class ConsoleSupportServiceProvider
 * @package Notadd\Foundation\Providers
 */
class ConsoleSupportServiceProvider extends AggregateServiceProvider {
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
        ConsoleServiceProvider::class
    ];
}