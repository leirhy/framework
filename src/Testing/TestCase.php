<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:59
 */
namespace Notadd\Foundation\Testing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Mockery;
use Notadd\Foundation\Testing\Concerns\ImpersonatesUsers;
use Notadd\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Notadd\Foundation\Testing\Concerns\InteractsWithConsole;
use Notadd\Foundation\Testing\Concerns\InteractsWithContainer;
use Notadd\Foundation\Testing\Concerns\InteractsWithDatabase;
use Notadd\Foundation\Testing\Concerns\InteractsWithSession;
use Notadd\Foundation\Testing\Concerns\MakesHttpRequests;
use Notadd\Foundation\Testing\Concerns\MocksApplicationServices;
use PHPUnit_Framework_TestCase;

/**
 * Class TestCase.
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    use InteractsWithContainer, MakesHttpRequests, ImpersonatesUsers, InteractsWithAuthentication, InteractsWithConsole, InteractsWithDatabase, InteractsWithSession, MocksApplicationServices;

    /**
     * The Illuminate application instance.
     *
     * @var \Notadd\Foundation\Application
     */
    protected $app;

    /**
     * The callbacks that should be run after the application is created.
     *
     * @var array
     */
    protected $afterApplicationCreatedCallbacks = [];

    /**
     * The callbacks that should be run before the application is destroyed.
     *
     * @var array
     */
    protected $beforeApplicationDestroyedCallbacks = [];

    /**
     * Indicates if we have made it through the base setUp function.
     *
     * @var bool
     */
    protected $setUpHasRun = false;

    /**
     * Creates the application.
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    abstract public function createApplication();

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        if (!$this->app) {
            $this->refreshApplication();
        }
        $this->setUpTraits();
        foreach ($this->afterApplicationCreatedCallbacks as $callback) {
            call_user_func($callback);
        }
        Facade::clearResolvedInstances();
        Model::setEventDispatcher($this->app['events']);
        $this->setUpHasRun = true;
    }

    /**
     * Refresh the application instance.
     *
     * @return void
     */
    protected function refreshApplication()
    {
        putenv('APP_ENV=testing');
        $this->app = $this->createApplication();
    }

    /**
     * Boot the testing helper traits.
     *
     * @return void
     */
    protected function setUpTraits()
    {
        $uses = array_flip(class_uses_recursive(static::class));
        if (isset($uses[DatabaseMigrations::class])) {
            $this->runDatabaseMigrations();
        }
        if (isset($uses[DatabaseTransactions::class])) {
            $this->beginDatabaseTransaction();
        }
        if (isset($uses[WithoutMiddleware::class])) {
            $this->disableMiddlewareForAllTests();
        }
        if (isset($uses[WithoutEvents::class])) {
            $this->disableEventsForAllTests();
        }
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     * @throws \Exception
     */
    protected function tearDown()
    {
        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }
            $this->app->flush();
            $this->app = null;
        }
        $this->setUpHasRun = false;
        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }
        if (class_exists('Mockery')) {
            Mockery::close();
        }
        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];
    }

    /**
     * Register a callback to be run after the application is created.
     *
     * @param callable $callback
     *
     * @return void
     */
    public function afterApplicationCreated(callable $callback)
    {
        $this->afterApplicationCreatedCallbacks[] = $callback;
        if ($this->setUpHasRun) {
            call_user_func($callback);
        }
    }

    /**
     * Register a callback to be run before the application is destroyed.
     *
     * @param callable $callback
     *
     * @return void
     */
    protected function beforeApplicationDestroyed(callable $callback)
    {
        $this->beforeApplicationDestroyedCallbacks[] = $callback;
    }
}
