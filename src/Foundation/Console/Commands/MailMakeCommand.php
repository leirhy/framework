<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:14
 */
namespace Notadd\Foundation\Console\Commands;
use Illuminate\Console\GeneratorCommand;
/**
 * Class MailMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class MailMakeCommand extends GeneratorCommand {
    /**
     * @var string
     */
    protected $name = 'make:mail';
    /**
     * @var string
     */
    protected $description = 'Create a new email class';
    /**
     * @var string
     */
    protected $type = 'Mail';
    /**
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/mail.stub';
    }
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Mail';
    }
}