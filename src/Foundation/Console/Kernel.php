<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 20:03
 */
namespace Notadd\Foundation\Console;
use Closure;
use Exception;
use Notadd\Foundation\Bootstrap\BootProviders;
use Notadd\Foundation\Bootstrap\ConfigureLogging;
use Notadd\Foundation\Bootstrap\DetectEnvironment;
use Notadd\Foundation\Bootstrap\HandleExceptions;
use Notadd\Foundation\Bootstrap\LoadConfiguration;
use Notadd\Foundation\Bootstrap\RegisterFacades;
use Notadd\Foundation\Bootstrap\RegisterProviders;
use Notadd\Foundation\Bootstrap\RegisterRouter;
use Notadd\Foundation\Bootstrap\SetRequestForConsole;
use Notadd\Foundation\Console\ClosureCommand;
use Throwable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Console\Kernel as KernelContract;
use Symfony\Component\Debug\Exception\FatalThrowableError;
/**
 * Class Kernel
 * @package Notadd\Console
 */
class Kernel implements KernelContract {
    /**
     * @var \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application
     */
    protected $app;
    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;
    /**
     * @var \Illuminate\Console\Application
     */
    protected $artisan;
    /**
     * @var array
     */
    protected $commands = [];
    /**
     * @var bool
     */
    protected $commandsLoaded = false;
    /**
     * The bootstrap classes for the application.
     * @var array
     */
    protected $bootstrappers = [
        DetectEnvironment::class,
        LoadConfiguration::class,
        ConfigureLogging::class,
        HandleExceptions::class,
        RegisterFacades::class,
        SetRequestForConsole::class,
        RegisterProviders::class,
        RegisterRouter::class,
        BootProviders::class,
    ];
    /**
     * Kernel constructor.
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct(Application $app, Dispatcher $events) {
        if(!defined('ARTISAN_BINARY')) {
            define('ARTISAN_BINARY', 'artisan');
        }
        $this->app = $app;
        $this->events = $events;
        $this->app->booted(function () {
            $this->defineConsoleSchedule();
        });
    }
    /**
     * @return void
     */
    protected function defineConsoleSchedule() {
        $this->app->instance('Illuminate\Console\Scheduling\Schedule', $schedule = new Schedule);
        $this->schedule($schedule);
    }
    /**
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    public function handle($input, $output = null) {
        try {
            $this->bootstrap();
            if(!$this->commandsLoaded) {
                $this->commands();
                $this->commandsLoaded = true;
            }
            return $this->getArtisan()->run($input, $output);
        } catch(Exception $e) {
            $this->reportException($e);
            $this->renderException($output, $e);
            return 1;
        } catch(Throwable $e) {
            $e = new FatalThrowableError($e);
            $this->reportException($e);
            $this->renderException($output, $e);
            return 1;
        }
    }
    /**
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  int $status
     * @return void
     */
    public function terminate($input, $status) {
        $this->app->terminate();
    }
    /**
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
    }
    /**
     * @return void
     */
    protected function commands() {
    }
    /**
     * @param  string $signature
     * @param  Closure $callback
     * @return \Notadd\Foundation\Console\ClosureCommand
     */
    public function command($signature, Closure $callback) {
        $command = new ClosureCommand($signature, $callback);
        $this->app['events']->listen(ArtisanStarting::class, function ($event) use ($command) {
            $event->artisan->add($command);
        });
        return $command;
    }
    /**
     * @param  \Symfony\Component\Console\Command\Command $command
     * @return void
     */
    public function registerCommand($command) {
        $this->getArtisan()->add($command);
    }
    /**
     * @param  string $command
     * @param  array $parameters
     * @return int
     */
    public function call($command, array $parameters = []) {
        $this->bootstrap();
        if(!$this->commandsLoaded) {
            $this->commands();
            $this->commandsLoaded = true;
        }
        return $this->getArtisan()->call($command, $parameters);
    }
    /**
     * @param  string $command
     * @param  array $parameters
     * @return void
     */
    public function queue($command, array $parameters = []) {
        $this->app['Illuminate\Contracts\Queue\Queue']->push('Illuminate\Foundation\Console\QueuedJob', func_get_args());
    }
    /**
     * @return array
     */
    public function all() {
        $this->bootstrap();
        return $this->getArtisan()->all();
    }
    /**
     * @return string
     */
    public function output() {
        $this->bootstrap();
        return $this->getArtisan()->output();
    }
    /**
     * @return void
     */
    public function bootstrap() {
        if(!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
        $this->app->loadDeferredProviders();
    }
    /**
     * @return \Illuminate\Console\Application
     */
    protected function getArtisan() {
        if(is_null($this->artisan)) {
            return $this->artisan = (new Artisan($this->app, $this->events, $this->app->version()))->resolveCommands($this->commands);
        }
        return $this->artisan;
    }
    /**
     * @param  \Illuminate\Console\Application|\Notadd\Foundation\Application $artisan
     * @return void
     */
    public function setArtisan($artisan) {
        $this->artisan = $artisan;
    }
    /**
     * @return array
     */
    protected function bootstrappers() {
        return $this->bootstrappers;
    }
    /**
     * @param  \Exception $e
     * @return void
     */
    protected function reportException(Exception $e) {
        $this->app['Illuminate\Contracts\Debug\ExceptionHandler']->report($e);
    }
    /**
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception $e
     * @return void
     */
    protected function renderException($output, Exception $e) {
        $this->app['Illuminate\Contracts\Debug\ExceptionHandler']->renderForConsole($output, $e);
    }
}
