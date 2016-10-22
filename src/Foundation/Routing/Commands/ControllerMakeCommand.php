<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 14:48
 */
namespace Notadd\Foundation\Routing\Commands;
use Carbon\Carbon;
use Illuminate\Routing\Console\ControllerMakeCommand as IlluminateControllerMakeCommand;
/**
 * Class ControllerMakeCommand
 * @package Notadd\Foundation\Routing\Commands
 */
class ControllerMakeCommand extends IlluminateControllerMakeCommand {
    /**
     * @return string
     */
    protected function getStub() {
        if($this->option('resource')) {
            return $this->laravel->basePath() . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'controller.stub';
        }
        return $this->laravel->basePath() . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'controller.plain.stub';
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