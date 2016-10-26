<?php
/**
 * This file is part of Notadd.
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
use Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar;
/**
 * Class ExtensionManager
 * @package Notadd\Extension
 */
class ExtensionManager {
    /**
     * @var array
     */
    protected $booted = [];
    /**
     * @var \Illuminate\Container\Container
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
    protected $filesystem;
    /**
     * ExtensionManager constructor.
     * @param \Illuminate\Container\Container|\Notadd\Foundation\Application $container
     * @param \Illuminate\Events\Dispatcher $events
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Container $container, Dispatcher $events, Filesystem $filesystem) {
        $this->container = $container;
        $this->events = $events;
        $this->extensions = new Collection();
        $this->filesystem = $filesystem;
    }
    /**
     * @param \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar $registrar
     * @throws \Exception
     */
    public function bootExtension(ExtensionRegistrar $registrar) {
        if(method_exists($registrar, 'register')) {
            $this->container->call([$registrar, 'register']);
        }
        $this->booted[get_class($registrar)] = $registrar;
    }
    /**
     * @return string
     */
    protected function getExtensionPath() {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'extensions';
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getExtensions() {
        if($this->extensions->isEmpty()) {
            if($this->filesystem->exists($file = $this->getVendorPath() . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'installed.json')) {
                $packages = new Collection(json_decode($this->filesystem->get($file), true));
                $packages->each(function (array $package) {
                    $name = Arr::get($package, 'name');
                    if(Arr::get($package, 'type') == 'notadd-extension' && $name) {
                        $extension = new Extension($name, $this->getVendorPath() . DIRECTORY_SEPARATOR . $name);
                        $this->extensions->put($extension->getId(), $extension);
                    }
                });
            }
            if($this->filesystem->isDirectory($this->getExtensionPath()) && !empty($directories = $this->filesystem->directories($this->getExtensionPath()))) {
                (new Collection($directories))->each(function($directory) {
                    if($this->filesystem->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                        $package = new Collection(json_decode($this->filesystem->get($file), true));
                        if(Arr::get($package, 'type') == 'notadd-extension' && $this->filesystem->exists($bootstrap = $directory . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
                            $extension = $this->filesystem->getRequire($bootstrap);
                            if(is_string($extension) && in_array(ExtensionRegistrar::class, class_parents($extension))) {
                                $registrar = $this->container->make($extension);
                                $extension = $registrar->getExtension();
                            }
                            if($extension instanceof Extension) {
                                $this->extensions->put($extension->getId(), $extension);
                            }
                        }
                    }
                });
            }
        }
        return $this->extensions;
    }
    /**
     * @return string
     */
    protected function getVendorPath() {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'vendor';
    }
}