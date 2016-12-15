<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:12
 */
namespace Notadd\Foundation\Queue\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class JobMakeCommand.
 */
class JobMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:job';

    /**
     * @var string
     */
    protected $description = 'Create a new job class';

    /**
     * @var string
     */
    protected $type = 'Job';

    /**
     * Get stub file.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('sync')) {
            return __DIR__ . '/../../../../stubs/jobs/job.stub';
        } else {
            return __DIR__ . '/../../../../stubs/jobs/job-queued.stub';
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Jobs';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'sync',
                null,
                InputOption::VALUE_NONE,
                'Indicates that job should be synchronous.',
            ],
        ];
    }

    /**
     * Replace the class name for the given stub.
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
