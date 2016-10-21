<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:22
 */
namespace Notadd\Foundation\Console;
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
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/test.stub';
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
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace;
    }
}