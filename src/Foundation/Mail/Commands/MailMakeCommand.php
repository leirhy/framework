<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:14
 */
namespace Notadd\Foundation\Mail\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;

/**
 * Class MailMakeCommand.
 */
class MailMakeCommand extends GeneratorCommand
{
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
     * TODO: Method getDefaultNamespace Description
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Mail';
    }

    /**
     * TODO: Method getStub Description
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../../stubs/mails/mail.stub';
    }

    /**
     * TODO: Method replaceClass Description
     *
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
