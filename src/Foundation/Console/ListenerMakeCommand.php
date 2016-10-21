<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:13
 */
namespace Notadd\Foundation\Console;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
/**
 * Class ListenerMakeCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class ListenerMakeCommand extends GeneratorCommand {
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
     * @return void
     */
    public function fire() {
        if(!$this->option('event')) {
            return $this->error('Missing required option: --event');
        }
        parent::fire();
    }
    /**
     * @param string $name
     * @return string
     */
    protected function buildClass($name) {
        $stub = parent::buildClass($name);
        $event = $this->option('event');
        if(!Str::startsWith($event, $this->laravel->getNamespace()) && !Str::startsWith($event, 'Illuminate')) {
            $event = $this->laravel->getNamespace() . 'Events\\' . $event;
        }
        $stub = str_replace('DummyEvent', class_basename($event), $stub);
        $stub = str_replace('DummyFullEvent', $event, $stub);
        return $stub;
    }
    /**
     * @return string
     */
    protected function getStub() {
        if($this->option('queued')) {
            return __DIR__ . '/stubs/listener-queued.stub';
        } else {
            return __DIR__ . '/stubs/listener.stub';
        }
    }
    /**
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName) {
        return class_exists($rawName);
    }
    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace . '\Listeners';
    }
    /**
     * @return array
     */
    protected function getOptions() {
        return [
            [
                'event',
                null,
                InputOption::VALUE_REQUIRED,
                'The event class being listened for.'
            ],
            [
                'queued',
                null,
                InputOption::VALUE_NONE,
                'Indicates the event listener should be queued.'
            ],
        ];
    }
}