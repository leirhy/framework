<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 09:50
 */
namespace Notadd\Foundation\Console;

use Illuminate\Console\Application as IlluminateApplication;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Application as ApplicationContract;
use Illuminate\Contracts\Events\Dispatcher;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class Application.
 */
class Application extends IlluminateApplication implements ApplicationContract
{
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
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     * @param                                         $version
     */
    public function __construct(Container $container, Dispatcher $events, $version)
    {
        parent::__construct($container, $events, $version);
        $this->container = $container;
    }

    /**
     * @param string $command
     * @param array  $parameters
     *
     * @return int
     */
    public function call($command, array $parameters = [])
    {
        $parameters = collect($parameters)->prepend($command);
        $this->lastOutput = new BufferedOutput();
        $this->setCatchExceptions(false);
        $result = $this->run(new ArrayInput($parameters->toArray()), $this->lastOutput);
        $this->setCatchExceptions(true);

        return $result;
    }

    /**
     * @param string $command
     *
     * @return \Symfony\Component\Console\Command\Command
     */
    public function resolve($command)
    {
        if (is_null($this->container)) {
            $this->container = Container::getInstance();
        }

        return $this->add($this->container->make($command));
    }

    /**
     * @param array|mixed $commands
     *
     * @return $this
     */
    public function resolveCommands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();
        foreach ($commands as $command) {
            $this->resolve($command);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function getContainer()
    {
        return $this->container;
    }
}
