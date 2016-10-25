<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:22
 */
namespace Notadd\Foundation\Console\Commands;
use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
/**
 * Class TestMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class TestMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:test';
    /**
     * @var string
     */
    protected $description = 'Create a new test class';
    /**
     * @var string
     */
    protected $type = 'Test';
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace;
    }
    /**
     * @param string $name
     * @return string
     */
    protected function getPath($name) {
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        return $this->laravel['path.base'] . '/tests/' . str_replace('\\', '/', $name) . '.php';
    }
    /**
     * @return string
     */
    protected function getStub() {
        return $this->laravel->basePath() . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'test.stub';
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