<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:19
 */
namespace Notadd\Foundation\Console;
use Illuminate\Console\GeneratorCommand;
/**
 * Class RequestMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class RequestMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:request';
    /**
     * @var string
     */
    protected $description = 'Create a new form request class';
    /**
     * @var string
     */
    protected $type = 'Request';
    /**
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/request.stub';
    }
    /**
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Http\Requests';
    }
}