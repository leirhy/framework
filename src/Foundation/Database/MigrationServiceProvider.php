<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 21:01
 */
namespace Notadd\Foundation\Database;

use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\MigrationServiceProvider as IlluminateMigrationServiceProvider;
use Notadd\Foundation\Database\Migrations\MigrationCreator;
use Notadd\Foundation\Database\Migrations\Migrator;

/**
 * Class MigrationServiceProvider.
 */
class MigrationServiceProvider extends IlluminateMigrationServiceProvider
{
    /**
     * @return void
     * TODO: Method registerCreator Description
     */
    protected function registerCreator()
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app, $app['files']);
        });
    }

    /**
     * @return void
     * TODO: Method registerMigrateCommand Description
     */
    protected function registerMigrateCommand()
    {
        $this->app->singleton('command.migrate', function ($app) {
            return new MigrateCommand($app['migrator']);
        });
    }

    /**
     * @return void
     * TODO: Method registerMigrator Description
     */
    protected function registerMigrator()
    {
        $this->app->singleton('migrator', function ($app) {
            $repository = $app['migration.repository'];

            return new Migrator($app, $repository, $app['db'], $app['files']);
        });
    }
}
