<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Foundation\Extension;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class ExtensionManager.
 */
class ExtensionManager
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $extensions;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * ExtensionManager constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Events\Dispatcher     $events
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Container $container, Dispatcher $events, Filesystem $files)
    {
        $this->container = $container;
        $this->events = $events;
        $this->extensions = new Collection();
        $this->files = $files;
    }

    /**
     * Path for extension.
     *
     * @return string
     */
    public function getExtensionPath()
    {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'extensions';
    }

    /**
     * Extension list.
     *
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getExtensions()
    {
        if ($this->extensions->isEmpty() && $this->container->isInstalled()) {
            if ($this->files->isDirectory($this->getExtensionPath())) {
                collect($this->files->directories($this->getExtensionPath()))->each(function ($vendor) {
                    collect($this->files->directories($vendor))->each(function ($directory) {
                        if ($this->files->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                            $package = new Collection(json_decode($this->files->get($file), true));
                            $name = Arr::get($package, 'name');
                            $type = Arr::get($package, 'type');
                            if ($type == 'notadd-extension' && $name) {
                                $extension = new Extension($name);
                                $extension->setAuthor(Arr::get($package, 'authors'));
                                $extension->setDescription(Arr::get($package, 'description'));
                                if ($entries = data_get($package, 'autoload.psr-4')) {
                                    foreach ($entries as $namespace => $entry) {
                                        $extension->setEntry($namespace . 'Extension');
                                    }
                                }
                                $this->extensions->put($directory, $extension);
                            }
                        }
                    });
                });
            }
        }

        return $this->extensions;
    }

    /**
     * Vendor Path.
     *
     * @return string
     */
    public function getVendorPath()
    {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'vendor';
    }
}
