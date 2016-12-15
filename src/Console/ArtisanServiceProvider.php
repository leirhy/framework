<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:56
 */
namespace Notadd\Foundation\Console;

use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Auth\Console\MakeAuthCommand;
use Illuminate\Queue\Console\FailedTableCommand;
use Illuminate\Queue\Console\TableCommand;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Cache\Commands\CacheTableCommand;
use Notadd\Foundation\Console\Commands\AppNameCommand;
use Notadd\Foundation\Console\Commands\ClearCompiledCommand;
use Notadd\Foundation\Console\Commands\ConfigCacheCommand;
use Notadd\Foundation\Console\Commands\ConfigClearCommand;
use Notadd\Foundation\Console\Commands\ConsoleMakeCommand;
use Notadd\Foundation\Console\Commands\DownCommand;
use Notadd\Foundation\Console\Commands\EnvironmentCommand;
use Notadd\Foundation\Console\Commands\EventGenerateCommand;
use Notadd\Foundation\Console\Commands\StorageLinkCommand;
use Notadd\Foundation\Console\Commands\TestMakeCommand;
use Notadd\Foundation\Console\Commands\TinkerCommand;
use Notadd\Foundation\Console\Commands\VendorPublishCommand;
use Notadd\Foundation\Database\Commands\ModelMakeCommand;
use Notadd\Foundation\Database\Commands\SeederMakeCommand;
use Notadd\Foundation\Event\Commands\EventMakeCommand;
use Notadd\Foundation\Event\Commands\ListenerMakeCommand;
use Notadd\Foundation\Http\Commands\RequestMakeCommand;
use Notadd\Foundation\Mail\Commands\MailMakeCommand;
use Notadd\Foundation\Notification\Commands\NotificationMakeCommand;
use Notadd\Foundation\Notification\Commands\NotificationTableCommand;
use Notadd\Foundation\Queue\Commands\JobMakeCommand;
use Notadd\Foundation\Routing\Commands\ControllerMakeCommand;
use Notadd\Foundation\Routing\Commands\MiddlewareMakeCommand;
use Notadd\Foundation\Routing\Commands\RouteCacheCommand;
use Notadd\Foundation\Routing\Commands\RouteClearCommand;
use Notadd\Foundation\Routing\Commands\RouteListCommand;
use Notadd\Foundation\Session\Commands\SessionTableCommand;

/**
 * Class ArtisanServiceProvider.
 */
class ArtisanServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @var array
     */
    protected $commands = [
        'ClearCompiled' => 'command.clear-compiled',
        'ClearResets'   => 'command.auth.resets.clear',
        'ConfigCache'   => 'command.config.cache',
        'ConfigClear'   => 'command.config.clear',
        'Down'          => 'command.down',
        'Environment'   => 'command.environment',
        'KeyGenerate'   => 'command.key.generate',
        'Optimize'      => 'command.optimize',
        'RouteCache'    => 'command.route.cache',
        'RouteClear'    => 'command.route.clear',
        'RouteList'     => 'command.route.list',
        'StorageLink'   => 'command.storage.link',
        'Tinker'        => 'command.tinker',
        'Up'            => 'command.up',
        'ViewClear'     => 'command.view.clear',
    ];

    /**
     * @var array
     */
    protected $devCommands = [
        //'AppName' => 'command.app.name',
        'AuthMake'          => 'command.auth.make',
        'CacheTable'        => 'command.cache.table',
        'ConsoleMake'       => 'command.console.make',
        'ControllerMake'    => 'command.controller.make',
        'EventGenerate'     => 'command.event.generate',
        'EventMake'         => 'command.event.make',
        'JobMake'           => 'command.job.make',
        'ListenerMake'      => 'command.listener.make',
        'MailMake'          => 'command.mail.make',
        'MiddlewareMake'    => 'command.middleware.make',
        'ModelMake'         => 'command.model.make',
        'NotificationMake'  => 'command.notification.make',
        'NotificationTable' => 'command.notification.table',
        'PolicyMake'        => 'command.policy.make',
        'QueueFailedTable'  => 'command.queue.failed-table',
        'QueueTable'        => 'command.queue.table',
        'RequestMake'       => 'command.request.make',
        'SeederMake'        => 'command.seeder.make',
        'SessionTable'      => 'command.session.table',
        'Serve'             => 'command.serve',
        'TestMake'          => 'command.test.make',
        'VendorPublish'     => 'command.vendor.publish',
    ];

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->registerCommands($this->commands);
        $this->registerCommands($this->devCommands);
    }

    /**
     * TODO: Method registerCommands Description
     *
     * @param array $commands
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $method = "register{$command}Command";
            call_user_func_array([
                $this,
                $method,
            ], []);
        }
        $this->commands(array_values($commands));
    }

    /**
     * TODO: Method registerAppNameCommand Description
     */
    protected function registerAppNameCommand()
    {
        $this->app->singleton('command.app.name', function ($app) {
            return new AppNameCommand($app['composer'], $app['files']);
        });
    }

    /**
     * TODO: Method registerAuthMakeCommand Description
     */
    protected function registerAuthMakeCommand()
    {
        $this->app->singleton('command.auth.make', function ($app) {
            return new MakeAuthCommand();
        });
    }

    /**
     * TODO: Method registerCacheTableCommand Description
     */
    protected function registerCacheTableCommand()
    {
        $this->app->singleton('command.cache.table', function ($app) {
            return new CacheTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * TODO: Method registerClearCompiledCommand Description
     */
    protected function registerClearCompiledCommand()
    {
        $this->app->singleton('command.clear-compiled', function () {
            return new ClearCompiledCommand();
        });
    }

    /**
     * TODO: Method registerClearResetsCommand Description
     */
    protected function registerClearResetsCommand()
    {
        $this->app->singleton('command.auth.resets.clear', function () {
            return new ClearResetsCommand();
        });
    }

    /**
     * TODO: Method registerConfigCacheCommand Description
     */
    protected function registerConfigCacheCommand()
    {
        $this->app->singleton('command.config.cache', function ($app) {
            return new ConfigCacheCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerConfigClearCommand Description
     */
    protected function registerConfigClearCommand()
    {
        $this->app->singleton('command.config.clear', function ($app) {
            return new ConfigClearCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerConsoleMakeCommand Description
     */
    protected function registerConsoleMakeCommand()
    {
        $this->app->singleton('command.console.make', function ($app) {
            return new ConsoleMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerControllerMakeCommand Description
     */
    protected function registerControllerMakeCommand()
    {
        $this->app->singleton('command.controller.make', function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerEventGenerateCommand Description
     */
    protected function registerEventGenerateCommand()
    {
        $this->app->singleton('command.event.generate', function () {
            return new EventGenerateCommand();
        });
    }

    /**
     * TODO: Method registerEventMakeCommand Description
     */
    protected function registerEventMakeCommand()
    {
        $this->app->singleton('command.event.make', function ($app) {
            return new EventMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerDownCommand Description
     */
    protected function registerDownCommand()
    {
        $this->app->singleton('command.down', function () {
            return new DownCommand();
        });
    }

    /**
     * TODO: Method registerEnvironmentCommand Description
     */
    protected function registerEnvironmentCommand()
    {
        $this->app->singleton('command.environment', function () {
            return new EnvironmentCommand();
        });
    }

    /**
     * TODO: Method registerJobMakeCommand Description
     */
    protected function registerJobMakeCommand()
    {
        $this->app->singleton('command.job.make', function ($app) {
            return new JobMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerKeyGenerateCommand Description
     */
    protected function registerKeyGenerateCommand()
    {
        $this->app->singleton('command.key.generate', function () {
            return new Commands\KeyGenerateCommand();
        });
    }

    /**
     * TODO: Method registerListenerMakeCommand Description
     */
    protected function registerListenerMakeCommand()
    {
        $this->app->singleton('command.listener.make', function ($app) {
            return new ListenerMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerMailMakeCommand Description
     */
    protected function registerMailMakeCommand()
    {
        $this->app->singleton('command.mail.make', function ($app) {
            return new MailMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerMiddlewareMakeCommand Description
     */
    protected function registerMiddlewareMakeCommand()
    {
        $this->app->singleton('command.middleware.make', function ($app) {
            return new MiddlewareMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerModelMakeCommand Description
     */
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.model.make', function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerNotificationMakeCommand Description
     */
    protected function registerNotificationMakeCommand()
    {
        $this->app->singleton('command.notification.make', function ($app) {
            return new NotificationMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerOptimizeCommand Description
     */
    protected function registerOptimizeCommand()
    {
        $this->app->singleton('command.optimize', function ($app) {
            return new Commands\OptimizeCommand($app['composer']);
        });
    }

    /**
     * TODO: Method registerQueueFailedTableCommand Description
     */
    protected function registerQueueFailedTableCommand()
    {
        $this->app->singleton('command.queue.failed-table', function ($app) {
            return new FailedTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * TODO: Method registerQueueTableCommand Description
     */
    protected function registerQueueTableCommand()
    {
        $this->app->singleton('command.queue.table', function ($app) {
            return new TableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * TODO: Method registerRequestMakeCommand Description
     */
    protected function registerRequestMakeCommand()
    {
        $this->app->singleton('command.request.make', function ($app) {
            return new RequestMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerSeederMakeCommand Description
     */
    protected function registerSeederMakeCommand()
    {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new SeederMakeCommand($app['files'], $app['composer']);
        });
    }

    /**
     * TODO: Method registerSessionTableCommand Description
     */
    protected function registerSessionTableCommand()
    {
        $this->app->singleton('command.session.table', function ($app) {
            return new SessionTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * TODO: Method registerStorageLinkCommand Description
     */
    protected function registerStorageLinkCommand()
    {
        $this->app->singleton('command.storage.link', function () {
            return new StorageLinkCommand();
        });
    }

    /**
     * TODO: Method registerRouteCacheCommand Description
     */
    protected function registerRouteCacheCommand()
    {
        $this->app->singleton('command.route.cache', function ($app) {
            return new RouteCacheCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerRouteClearCommand Description
     */
    protected function registerRouteClearCommand()
    {
        $this->app->singleton('command.route.clear', function ($app) {
            return new RouteClearCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerRouteListCommand Description
     */
    protected function registerRouteListCommand()
    {
        $this->app->singleton('command.route.list', function ($app) {
            return new RouteListCommand($app['router']);
        });
    }

    /**
     * TODO: Method registerServeCommand Description
     */
    protected function registerServeCommand()
    {
        $this->app->singleton('command.serve', function () {
            return new Commands\ServeCommand();
        });
    }

    /**
     * TODO: Method registerTestMakeCommand Description
     */
    protected function registerTestMakeCommand()
    {
        $this->app->singleton('command.test.make', function ($app) {
            return new TestMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerTinkerCommand Description
     */
    protected function registerTinkerCommand()
    {
        $this->app->singleton('command.tinker', function () {
            return new TinkerCommand();
        });
    }

    /**
     * TODO: Method registerUpCommand Description
     */
    protected function registerUpCommand()
    {
        $this->app->singleton('command.up', function () {
            return new Commands\UpCommand();
        });
    }

    /**
     * TODO: Method registerVendorPublishCommand Description
     */
    protected function registerVendorPublishCommand()
    {
        $this->app->singleton('command.vendor.publish', function ($app) {
            return new VendorPublishCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerViewClearCommand Description
     */
    protected function registerViewClearCommand()
    {
        $this->app->singleton('command.view.clear', function ($app) {
            return new Commands\ViewClearCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerPolicyMakeCommand Description
     */
    protected function registerPolicyMakeCommand()
    {
        $this->app->singleton('command.policy.make', function ($app) {
            return new Commands\PolicyMakeCommand($app['files']);
        });
    }

    /**
     * TODO: Method registerNotificationTableCommand Description
     */
    protected function registerNotificationTableCommand()
    {
        $this->app->singleton('command.notification.table', function ($app) {
            return new NotificationTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        if ($this->app->environment('production')) {
            return array_values($this->commands);
        } else {
            return array_merge(array_values($this->commands), array_values($this->devCommands));
        }
    }
}
