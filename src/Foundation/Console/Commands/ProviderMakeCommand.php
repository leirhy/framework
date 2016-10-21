<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:17
 */
namespace Notadd\Foundation\Console\Commands;
use Illuminate\Console\GeneratorCommand;
/**
 * Class ProviderMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class ProviderMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:provider';
    /**
     * @var string
     */
    protected $description = 'Create a new service provider class';
    /**
     * @var string
     */
    protected $type = 'Provider';
    /**
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/provider.stub';
    }
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Providers';
    }
}