<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 09:50
 */
namespace Notadd\Foundation\Console;
use Illuminate\Console\Command;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Contracts\Console\Application as ApplicationContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
/**
 * Class Application
 * @package Notadd\Foundation\Console
 */
class Application extends SymfonyApplication implements ApplicationContract {
    /**
     * @var \Illuminate\Contracts\Container\Container|\Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application
     */
    protected $container;
    /**
     * @var \Symfony\Component\Console\Output\BufferedOutput
     */
    protected $lastOutput;
    /**
     * Application constructor.
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     * @param $version
     */
    public function __construct(Container $container, Dispatcher $events, $version) {
        parent::__construct('Notadd Framework', $version);
        $this->container = $container;
        $this->setAutoExit(false);
        $this->setCatchExceptions(false);
        $events->fire(new ArtisanStarting($this));
    }
    /**
     * @param string $command
     * @param array $parameters
     * @return int
     */
    public function call($command, array $parameters = []) {
        $parameters = collect($parameters)->prepend($command);
        $this->lastOutput = new BufferedOutput;
        $this->setCatchExceptions(false);
        $result = $this->run(new ArrayInput($parameters->toArray()), $this->lastOutput);
        $this->setCatchExceptions(true);
        return $result;
    }
    /**
     * @return string
     */
    public function output() {
        return $this->lastOutput ? $this->lastOutput->fetch() : '';
    }
    /**
     * @param \Symfony\Component\Console\Command\Command $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function add(SymfonyCommand $command) {
        if($command instanceof Command) {
            $command->setLaravel($this->container);
        }
        return $this->addToParent($command);
    }
    /**
     * @param \Symfony\Component\Console\Command\Command $command
     * @return \Symfony\Component\Console\Command\Command
     */
    protected function addToParent(SymfonyCommand $command) {
        return parent::add($command);
    }
    /**
     * @param string $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function resolve($command) {
        return $this->add($this->container->make($command));
    }
    /**
     * @param array|mixed $commands
     * @return $this
     */
    public function resolveCommands($commands) {
        $commands = is_array($commands) ? $commands : func_get_args();
        foreach($commands as $command) {
            $this->resolve($command);
        }
        return $this;
    }
    /**
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition() {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption($this->getEnvironmentOption());
        return $definition;
    }
    /**
     * @return \Symfony\Component\Console\Input\InputOption
     */
    protected function getEnvironmentOption() {
        $message = 'The environment the command should run under.';
        return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function getContainer() {
        return $this->container;
    }
}