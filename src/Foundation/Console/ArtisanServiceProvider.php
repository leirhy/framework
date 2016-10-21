<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 11:56
 */
namespace Notadd\Foundation\Console;
use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Auth\Console\MakeAuthCommand;
use Illuminate\Cache\Console\CacheTableCommand;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Notifications\Console\NotificationTableCommand;
use Illuminate\Queue\Console\FailedTableCommand;
use Illuminate\Queue\Console\TableCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Illuminate\Session\Console\SessionTableCommand;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Console\Commands\AppNameCommand;
use Notadd\Foundation\Console\Commands\ClearCompiledCommand;
use Notadd\Foundation\Console\Commands\ConfigCacheCommand;
use Notadd\Foundation\Console\Commands\ConfigClearCommand;
use Notadd\Foundation\Console\Commands\ConsoleMakeCommand;
use Notadd\Foundation\Console\Commands\DownCommand;
use Notadd\Foundation\Console\Commands\EnvironmentCommand;
use Notadd\Foundation\Console\Commands\EventGenerateCommand;
use Notadd\Foundation\Console\Commands\EventMakeCommand;
use Notadd\Foundation\Console\Commands\JobMakeCommand;
use Notadd\Foundation\Console\Commands\KeyGenerateCommand;
use Notadd\Foundation\Console\Commands\ListenerMakeCommand;
use Notadd\Foundation\Console\Commands\MailMakeCommand;
use Notadd\Foundation\Console\Commands\ModelMakeCommand;
use Notadd\Foundation\Console\Commands\NotificationMakeCommand;
use Notadd\Foundation\Console\Commands\OptimizeCommand;
use Notadd\Foundation\Console\Commands\PolicyMakeCommand;
use Notadd\Foundation\Console\Commands\ProviderMakeCommand;
use Notadd\Foundation\Console\Commands\RequestMakeCommand;
use Notadd\Foundation\Console\Commands\RouteCacheCommand;
use Notadd\Foundation\Console\Commands\RouteClearCommand;
use Notadd\Foundation\Console\Commands\RouteListCommand;
use Notadd\Foundation\Console\Commands\ServeCommand;
use Notadd\Foundation\Console\Commands\StorageLinkCommand;
use Notadd\Foundation\Console\Commands\TestMakeCommand;
use Notadd\Foundation\Console\Commands\TinkerCommand;
use Notadd\Foundation\Console\Commands\UpCommand;
use Notadd\Foundation\Console\Commands\VendorPublishCommand;
use Notadd\Foundation\Console\Commands\ViewClearCommand;
/**
 * Class ArtisanServiceProvider
 * @package Notadd\Foundation\Providers
 */
class ArtisanServiceProvider extends ServiceProvider {
    /**
     * @var bool
     */
    protected $defer = true;
    /**
     * @var array
     */
    protected $commands = [
        'ClearCompiled' => 'command.clear-compiled',
        'ClearResets' => 'command.auth.resets.clear',
        'ConfigCache' => 'command.config.cache',
        'ConfigClear' => 'command.config.clear',
        'Down' => 'command.down',
        'Environment' => 'command.environment',
        'KeyGenerate' => 'command.key.generate',
        'Optimize' => 'command.optimize',
        'RouteCache' => 'command.route.cache',
        'RouteClear' => 'command.route.clear',
        'RouteList' => 'command.route.list',
        'StorageLink' => 'command.storage.link',
        'Tinker' => 'command.tinker',
        'Up' => 'command.up',
        'ViewClear' => 'command.view.clear',
    ];
    /**
     * @var array
     */
    protected $devCommands = [
        'AppName' => 'command.app.name',
        'AuthMake' => 'command.auth.make',
        'CacheTable' => 'command.cache.table',
        'ConsoleMake' => 'command.console.make',
        'ControllerMake' => 'command.controller.make',
        'EventGenerate' => 'command.event.generate',
        'EventMake' => 'command.event.make',
        'JobMake' => 'command.job.make',
        'ListenerMake' => 'command.listener.make',
        'MailMake' => 'command.mail.make',
        'MiddlewareMake' => 'command.middleware.make',
        'ModelMake' => 'command.model.make',
        'NotificationMake' => 'command.notification.make',
        'NotificationTable' => 'command.notification.table',
        'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        'QueueFailedTable' => 'command.queue.failed-table',
        'QueueTable' => 'command.queue.table',
        'RequestMake' => 'command.request.make',
        'SeederMake' => 'command.seeder.make',
        'SessionTable' => 'command.session.table',
        'Serve' => 'command.serve',
        'TestMake' => 'command.test.make',
        'VendorPublish' => 'command.vendor.publish',
    ];
    /**
     * @return void
     */
    public function register() {
        $this->registerCommands($this->commands);
        $this->registerCommands($this->devCommands);
    }
    /**
     * @param array $commands
     * @return void
     */
    protected function registerCommands(array $commands) {
        foreach(array_keys($commands) as $command) {
            $method = "register{$command}Command";
            call_user_func_array([
                $this,
                $method
            ], []);
        }
        $this->commands(array_values($commands));
    }
    /**
     * @return void
     */
    protected function registerAppNameCommand() {
        $this->app->singleton('command.app.name', function ($app) {
            return new AppNameCommand($app['composer'], $app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerAuthMakeCommand() {
        $this->app->singleton('command.auth.make', function ($app) {
            return new MakeAuthCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerCacheTableCommand() {
        $this->app->singleton('command.cache.table', function ($app) {
            return new CacheTableCommand($app['files'], $app['composer']);
        });
    }
    /**
     * @return void
     */
    protected function registerClearCompiledCommand() {
        $this->app->singleton('command.clear-compiled', function () {
            return new ClearCompiledCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerClearResetsCommand() {
        $this->app->singleton('command.auth.resets.clear', function () {
            return new ClearResetsCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerConfigCacheCommand() {
        $this->app->singleton('command.config.cache', function ($app) {
            return new ConfigCacheCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerConfigClearCommand() {
        $this->app->singleton('command.config.clear', function ($app) {
            return new ConfigClearCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerConsoleMakeCommand() {
        $this->app->singleton('command.console.make', function ($app) {
            return new ConsoleMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerControllerMakeCommand() {
        $this->app->singleton('command.controller.make', function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerEventGenerateCommand() {
        $this->app->singleton('command.event.generate', function () {
            return new EventGenerateCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerEventMakeCommand() {
        $this->app->singleton('command.event.make', function ($app) {
            return new Commands\EventMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerDownCommand() {
        $this->app->singleton('command.down', function () {
            return new DownCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerEnvironmentCommand() {
        $this->app->singleton('command.environment', function () {
            return new EnvironmentCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerJobMakeCommand() {
        $this->app->singleton('command.job.make', function ($app) {
            return new Commands\JobMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerKeyGenerateCommand() {
        $this->app->singleton('command.key.generate', function () {
            return new Commands\KeyGenerateCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerListenerMakeCommand() {
        $this->app->singleton('command.listener.make', function ($app) {
            return new ListenerMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerMailMakeCommand() {
        $this->app->singleton('command.mail.make', function ($app) {
            return new Commands\MailMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerMiddlewareMakeCommand() {
        $this->app->singleton('command.middleware.make', function ($app) {
            return new MiddlewareMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerModelMakeCommand() {
        $this->app->singleton('command.model.make', function ($app) {
            return new Commands\ModelMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerNotificationMakeCommand() {
        $this->app->singleton('command.notification.make', function ($app) {
            return new Commands\NotificationMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerOptimizeCommand() {
        $this->app->singleton('command.optimize', function ($app) {
            return new Commands\OptimizeCommand($app['composer']);
        });
    }
    /**
     * @return void
     */
    protected function registerProviderMakeCommand() {
        $this->app->singleton('command.provider.make', function ($app) {
            return new ProviderMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerQueueFailedTableCommand() {
        $this->app->singleton('command.queue.failed-table', function ($app) {
            return new FailedTableCommand($app['files'], $app['composer']);
        });
    }
    /**
     * @return void
     */
    protected function registerQueueTableCommand() {
        $this->app->singleton('command.queue.table', function ($app) {
            return new TableCommand($app['files'], $app['composer']);
        });
    }
    /**
     * @return void
     */
    protected function registerRequestMakeCommand() {
        $this->app->singleton('command.request.make', function ($app) {
            return new RequestMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerSeederMakeCommand() {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new SeederMakeCommand($app['files'], $app['composer']);
        });
    }
    /**
     * @return void
     */
    protected function registerSessionTableCommand() {
        $this->app->singleton('command.session.table', function ($app) {
            return new SessionTableCommand($app['files'], $app['composer']);
        });
    }
    /**
     * @return void
     */
    protected function registerStorageLinkCommand() {
        $this->app->singleton('command.storage.link', function () {
            return new StorageLinkCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerRouteCacheCommand() {
        $this->app->singleton('command.route.cache', function ($app) {
            return new Commands\RouteCacheCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerRouteClearCommand() {
        $this->app->singleton('command.route.clear', function ($app) {
            return new RouteClearCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerRouteListCommand() {
        $this->app->singleton('command.route.list', function ($app) {
            return new Commands\RouteListCommand($app['router']);
        });
    }
    /**
     * @return void
     */
    protected function registerServeCommand() {
        $this->app->singleton('command.serve', function () {
            return new Commands\ServeCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerTestMakeCommand() {
        $this->app->singleton('command.test.make', function ($app) {
            return new TestMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerTinkerCommand() {
        $this->app->singleton('command.tinker', function () {
            return new TinkerCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerUpCommand() {
        $this->app->singleton('command.up', function () {
            return new Commands\UpCommand;
        });
    }
    /**
     * @return void
     */
    protected function registerVendorPublishCommand() {
        $this->app->singleton('command.vendor.publish', function ($app) {
            return new VendorPublishCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerViewClearCommand() {
        $this->app->singleton('command.view.clear', function ($app) {
            return new Commands\ViewClearCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerPolicyMakeCommand() {
        $this->app->singleton('command.policy.make', function ($app) {
            return new Commands\PolicyMakeCommand($app['files']);
        });
    }
    /**
     * @return void
     */
    protected function registerNotificationTableCommand() {
        $this->app->singleton('command.notification.table', function ($app) {
            return new NotificationTableCommand($app['files'], $app['composer']);
        });
    }
    /**
     * @return array
     */
    public function provides() {
        if($this->app->environment('production')) {
            return array_values($this->commands);
        } else {
            return array_merge(array_values($this->commands), array_values($this->devCommands));
        }
    }
}