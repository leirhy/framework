<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:06
 */
namespace Notadd\Foundation\Extension;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Extension\Commands\ListCommand;

/**
 * Class ExtensionServiceProvider.
 */
class ExtensionServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected static $complies;

    /**
     * ExtensionServiceProvider constructor.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function __construct($application)
    {
        parent::__construct($application);
        static::$complies = new Collection();
    }

    /**
     * Boot service provider.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function boot()
    {
        $this->app->make('extension')->getExtensions()->each(function (Extension $extension, $path) {
            if ($this->app->make('files')->isDirectory($path) && is_string($extension->getEntry())) {
                $this->app->register($extension->getEntry());
            }
        });
        $this->commands([
            ListCommand::class,
        ]);
    }

    /**
     * Compiles define by extension.
     *
     * @return array
     */
    public static function compiles()
    {
        return static::$complies->toArray();
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('extension', function ($app) {
            return new ExtensionManager($app, $app['events'], $app['files']);
        });
    }
}
