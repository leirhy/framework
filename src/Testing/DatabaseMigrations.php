<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:30
 */
namespace Notadd\Foundation\Testing;

use Illuminate\Contracts\Console\Kernel;

/**
 * Class DatabaseMigrations.
 */
trait DatabaseMigrations
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate');
        $this->app[Kernel::class]->setArtisan(null);
        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }
}
