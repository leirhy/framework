<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-14 20:27
 */
namespace Notadd\Foundation\Http\Detectors;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Addon\Addon;
use Notadd\Foundation\Addon\AddonManager;
use Notadd\Foundation\Http\Contracts\Detector;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Module\ModuleManager;

/**
 * Class SubscriberDetector.
 */
class SubscriberDetector implements Detector
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
        $classes = collect();
        collect($this->file->files($path))->each(function ($file) use ($classes, $namespace) {
            $class = '';
            $this->file->extension($file) == 'php' && $class = $namespace . '\\' . $this->file->name($file);
            class_exists($class) && $classes->push($class);
        });

        return $classes->toArray();
    }

    /**
     * Do.
     *
     * @param $target
     */
    public function do($target)
    {
        $this->event->subscribe($target);
    }

    /**
     * Paths definition.
     *
     * @return array
     */
    public function paths()
    {
        $paths = collect();
        collect($this->file->directories($this->container->frameworkPath('src')))->each(function ($directory) use ($paths) {
            $location = realpath($directory . DIRECTORY_SEPARATOR . 'Subscribers');
            $this->file->isDirectory($location) && $paths->push([
                'namespace' => '\\Notadd\\Foundation\\' . $this->file->name($directory) . '\\Subscribers',
                'path'      => $location,
            ]);
        });
        if ($this->container->isInstalled()) {
            $this->container->make(ModuleManager::class)->repository()->enabled()->each(function (Module $module) use ($paths) {
                $location = realpath($module->get('directory') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Subscribers');
                $this->file->isDirectory($location) && $paths->push([
                    'namespace' => $module->get('namespace') . 'Subscribers',
                    'path'      => $location,
                ]);
            });
            $this->container->make(AddonManager::class)->repository()->enabled()->each(function (Addon $extension) use ($paths) {
                $location = realpath($extension->get('directory') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Subscribers');
                $this->file->isDirectory($location) && $paths->push([
                    'namespace' => $extension->get('namespace') . 'Subscribers',
                    'path'      => $location,
                ]);
            });
        }

        return $paths->toArray();
    }
}
