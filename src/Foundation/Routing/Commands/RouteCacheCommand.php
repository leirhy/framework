<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 12:19
 */
namespace Notadd\Foundation\Routing\Commands;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\RouteCollection;
use Notadd\Foundation\Application;
use Notadd\Foundation\Console\Kernel as ConsoleKernel;
use Notadd\Foundation\Exception\Handler;
use Notadd\Foundation\Http\Kernel;
/**
 * Class RouteCacheCommand
 * @package Notadd\Foundation\Console\Consoles
 */
class RouteCacheCommand extends Command {
    /**
     * @var string
     */
    protected $name = 'route:cache';
    /**
     * @var string
     */
    protected $description = 'Create a route cache file for faster route registration';
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * RouteCacheCommand constructor.
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files) {
        parent::__construct();
        $this->files = $files;
    }
    /**
     * @return bool
     */
    public function fire() {
        $this->call('route:clear');
        $routes = $this->getFreshApplicationRoutes();
        if(count($routes) == 0) {
            $this->error("Your application doesn't have any routes.");
            return false;
        }
        foreach($routes as $route) {
            $route->prepareForSerialization();
        }
        $this->files->put($this->laravel->getCachedRoutesPath(), $this->buildRouteCacheFile($routes));
        $this->info('Routes cached successfully!');
        return true;
    }
    /**
     * @return \Illuminate\Routing\RouteCollection
     */
    protected function getFreshApplicationRoutes() {
        $application = new Application($this->laravel->basePath());
        $application->singleton(HttpKernelContract::class, Kernel::class);
        $application->singleton(ConsoleKernelContract::class, ConsoleKernel::class);
        $application->singleton(ExceptionHandler::class, Handler::class);
        $application->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        return $application['router']->getRoutes();
    }
    /**
     * @param \Illuminate\Routing\RouteCollection $routes
     * @return string
     */
    protected function buildRouteCacheFile(RouteCollection $routes) {
        $stub = $this->files->get($this->laravel->basePath() . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'caches.stub');
        $stub = str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
        return str_replace('{{routes}}', base64_encode(serialize($routes)), $stub);
    }
}