<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:15
 */
namespace Notadd\Foundation\Console;
use Illuminate\Console\GeneratorCommand;
/**
 * Class NotificationMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class NotificationMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:notification';
    /**
     * @var string
     */
    protected $description = 'Create a new notification class';
    /**
     * @var string
     */
    protected $type = 'Notification';
    /**
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/notification.stub';
    }
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Notifications';
    }
}