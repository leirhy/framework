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
use Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar;

/**
 * Class ExtensionManager.
 */
class ExtensionManager
{
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
    protected $files;

    /**
     * ExtensionManager constructor.
     *
     * @param \Illuminate\Container\Container|\Notadd\Foundation\Application $container
     * @param \Illuminate\Events\Dispatcher                                  $events
     * @param \Illuminate\Filesystem\Filesystem                              $files
     */
    public function __construct(Container $container, Dispatcher $events, Filesystem $files)
    {
        $this->container = $container;
        $this->events = $events;
        $this->extensions = new Collection();
        $this->files = $files;
    }

    /**
     * Boot service provider.
     *
     * @param \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar $registrar
     *
     * @throws \Exception
     */
    public function boot(ExtensionRegistrar $registrar)
    {
        if (method_exists($registrar, 'register')) {
            $this->container->call([
                $registrar,
                'register',
            ]);
        }
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
        if ($this->extensions->isEmpty()) {
            if ($this->files->isDirectory($this->getExtensionPath()) && !empty($vendors = $this->files->directories($this->getExtensionPath()))) {
                collect($vendors)->each(function ($vendor) {
                    if ($this->files->isDirectory($vendor) && !empty($directories = $this->files->directories($vendor))) {
                        collect($directories)->each(function ($directory) {
                            if ($this->files->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                                $package = new Collection(json_decode($this->files->get($file), true));
                                if (Arr::get($package, 'type') == 'notadd-extension' && $name = Arr::get($package,
                                        'name')
                                ) {
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
                    }
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
