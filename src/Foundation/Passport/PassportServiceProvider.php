<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 17:21
 */
namespace Notadd\Foundation\Passport;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Laravel\Passport\PassportServiceProvider as LaravelPassportServiceProvider;
/**
 * Class PassportServiceProvider
 * @package Notadd\Foundation\Passport
 */
class PassportServiceProvider extends LaravelPassportServiceProvider {
    /**
     * @return void
     */
    public function boot() {
        $this->commands([
            ClientCommand::class,
            InstallCommand::class,
            KeysCommand::class,
        ]);
    }
}