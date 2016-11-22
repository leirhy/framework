<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:13
 */
namespace Notadd\Foundation\Event\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ListenerMakeCommand.
 */
class ListenerMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:listener';
    /**
     * @var string
     */
    protected $description = 'Create a new event listener class';
    /**
     * @var string
     */
    protected $type = 'Listener';

    /**
     * @return bool
     */
    public function fire()
    {
        if (!$this->option('event')) {
            $this->error('Missing required option: --event');

            return false;
        }
        parent::fire();

        return true;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $event = $this->option('event');
        if (!Str::startsWith($event, $this->laravel->getNamespace()) && !Str::startsWith($event, 'Illuminate')) {
            $event = $this->laravel->getNamespace() . 'Events\\' . $event;
        }
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        $stub = str_replace('DummyEvent', class_basename($event), $stub);
        $stub = str_replace('DummyFullEvent', $event, $stub);

        return $stub;
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('queued')) {
            return __DIR__ . '/../../../../stubs/events/listener-queued.stub';
        } else {
            return __DIR__ . '/../../../../stubs/events/listener.stub';
        }
    }

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
        return $rootNamespace . '\Listeners';
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'event',
                null,
                InputOption::VALUE_REQUIRED,
                'The event class being listened for.',
            ],
            [
                'queued',
                null,
                InputOption::VALUE_NONE,
                'Indicates the event listener should be queued.',
            ],
        ];
    }
}
