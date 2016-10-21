<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:11
 */
namespace Notadd\Foundation\Console\Commands;
use Illuminate\Console\GeneratorCommand;
/**
 * Class EventMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class EventMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:event';
    /**
     * @var string
     */
    protected $description = 'Create a new event class';
    /**
     * @var string
     */
    protected $type = 'Event';
    /**
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName) {
        return class_exists($rawName);
    }
    /**
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/event.stub';
    }
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Events';
    }
}