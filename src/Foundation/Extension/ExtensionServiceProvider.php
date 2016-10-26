<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:06
 */
namespace Notadd\Foundation\Extension;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
/**
 * Class ExtensionServiceProvider
 * @package Notadd\Extension
 */
class ExtensionServiceProvider extends ServiceProvider {
    /**
     * @var \Illuminate\Support\Collection
     */
    protected static $complies;
    /**
     * ExtensionServiceProvider constructor.
     * @param \Notadd\Foundation\Application $application
     */
    public function __construct($application) {
        parent::__construct($application);
        static::$complies = new Collection();
    }
    /**
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function boot(ExtensionManager $manager = null) {
        $extensions = $manager->getExtensions();
        $extensions->each(function(Extension $extension) use($manager) {
            $registrar = $extension->getRegistrar();
            static::$complies = static::$complies->merge($registrar->compiles());
            (new Collection($registrar->loadCommands()))->each(function($command) {
                $this->commands($command);
            });
            (new Collection($registrar->loadLocalizationsFrom()))->each(function($path, $namespace) {
                $this->loadTranslationsFrom($path, $namespace);
            });
            (new Collection($registrar->loadMigrationsFrom()))->each(function($paths) {
                $this->loadMigrationsFrom($paths);
            });
            (new Collection($registrar->loadViewsFrom()))->each(function($path, $namespace) {
                $this->loadViewsFrom($path, $namespace);
            });
            $manager->bootExtension($registrar);
        });
    }
    /**
     * @return array
     */
    public static function compiles() {
        return static::$complies->toArray();
    }
    /**
     * @return void
     */
    public function register() {
        $this->app->singleton('extensions', function($app) {
            return new ExtensionManager($app, $app['events'], $app['files']);
        });
    }
}