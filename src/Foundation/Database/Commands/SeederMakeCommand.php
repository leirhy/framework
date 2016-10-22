<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 15:34
 */
namespace Notadd\Foundation\Database\Commands;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\SeederMakeCommand as IlluminateSeederMakeCommand;
/**
 * Class SeederMakeCommand
 * @package Notadd\Foundation\Database\Commands
 */
class SeederMakeCommand extends IlluminateSeederMakeCommand {
    /**
     * @return string
     */
    protected function getStub() {
        return $this->laravel->basePath() . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'seeder.stub';
    }
    /**
     * @param string $stub
     * @param string $name
     * @return mixed
     */
    protected function replaceClass($stub, $name) {
        $stub = parent::replaceClass($stub, $name);
        return str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
    }
}