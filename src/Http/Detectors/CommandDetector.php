<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-15 17:49
 */
namespace Notadd\Foundation\Http\Detectors;

use Illuminate\Console\Application as Artisan;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Extension\Extension;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Http\Contracts\Detector;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Module\ModuleManager;

/**
 * Class CommandDetector.
 */
class CommandDetector implements Detector
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $event;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * ListenerDetector constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Events\Dispatcher     $event
     * @param \Illuminate\Filesystem\Filesystem $file
     */
    public function __construct(Container $container, Dispatcher $event, Filesystem $file)
    {
        $this->container = $container;
        $this->file = $file;
        $this->event = $event;
    }

    /**
     * Detect paths.
     *
     * @param string $path
     * @param string $namespace
     *
     * @return array
     */
    public function detect(string $path, string $namespace)
    {
        $collection = collect();
        collect($this->file->files($path))->each(function ($file) use ($collection, $namespace) {
            $class = '';
            $this->file->extension($file) == 'php' && $class = $namespace . '\\' . $this->file->name($file);
            class_exists($class) && $collection->push($class);
        });

        return $collection->toArray();
    }

    /**
     * Do.
     *
     * @param $target
     */
    public function do($target)
    {
        Artisan::starting(function (Artisan $artisan) use ($target) {
            $artisan->resolve($target);
        });
    }

    /**
     * Paths definition.
     *
     * @return array
     */
    public function paths()
    {
        $collection = collect();
        if ($this->container->isInstalled()) {
            $this->container->make(ModuleManager::class)->repository()->enabled()->each(function (Module $module) use ($collection) {
                $location = realpath($module->get('directory') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Commands');
                $this->file->isDirectory($location) && $collection->push([
                    'namespace' => $module->get('namespace') . 'Commands',
                    'path'      => $location,
                ]);
            });
            $this->container->make(ExtensionManager::class)->getEnabledExtensions()->each(function (Extension $extension) use ($collection) {
                $location = realpath($extension->get('directory') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Commands');
                $this->file->isDirectory($location) && $collection->push([
                    'namespace' => $extension->get('namespace') . 'Commands',
                    'path'      => $location,
                ]);
            });
        }

        return $collection->toArray();
    }
}
