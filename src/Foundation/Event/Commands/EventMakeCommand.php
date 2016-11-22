<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:11
 */
namespace Notadd\Foundation\Event\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;

/**
 * Class EventMakeCommand.
 */
class EventMakeCommand extends GeneratorCommand
{
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
     *
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    /**
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Events';
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../../stubs/events/event.stub';
    }

    /**
     * @param string $stub
     * @param string $name
     *
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
    }
}
