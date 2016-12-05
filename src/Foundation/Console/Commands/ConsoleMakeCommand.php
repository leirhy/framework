<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:08
 */
namespace Notadd\Foundation\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ConsoleMakeCommand.
 */
class ConsoleMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:command';

    /**
     * @var string
     */
    protected $description = 'Create a new Artisan command';

    /**
     * @var string
     */
    protected $type = 'Console command';

    /**
     * TODO: Method replaceClass Description
     *
     * @param string $stub
     * @param string $name
     *
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);

        return str_replace('dummy:command', $this->option('command'), $stub);
    }

    /**
     * TODO: Method getStub Description
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../../stubs/consoles/command.stub';
    }

    /**
     * TODO: Method getDefaultNamespace Description
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Console\Commands';
    }

    /**
     * TODO: Method getArguments Description
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of the command.',
            ],
        ];
    }

    /**
     * TODO: Method getOptions Description
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'command',
                null,
                InputOption::VALUE_OPTIONAL,
                'The terminal command that should be assigned.',
                'command:name',
            ],
        ];
    }
}
