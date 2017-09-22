<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Foundation\Addon;

use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Notadd\Foundation\Addon\Addon;
use Notadd\Foundation\Addon\Repositories\AddonRepository;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ExtensionManager.
 */
class AddonManager
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
    protected $excepts;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $extensions;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    protected $repository;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $unloaded;

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
        $this->excepts = collect();
        $this->extensions = collect();
        $this->file = $files;
        $this->unloaded = collect();
    }

    /**
     * Get a extension by name.
     *
     * @param $name
     *
     * @return \Notadd\Foundation\Addon\Addon
     */
    public function get($name): Addon
    {
        return $this->extensions->get($name);
    }

    /**
     * Extensions of enabled.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEnabledExtensions(): Collection
    {
        $list = new Collection();
        if ($this->getExtensions()->isEmpty()) {
            return $list;
        }
        $this->extensions->each(function (Addon $extension) use ($list) {
            $extension->isEnabled() && $list->push($extension);
        });

        return $list;
    }

    /**
     * @return \Notadd\Foundation\Addon\Repositories\AddonRepository
     */
    public function repository(): AddonRepository
    {
        if (!$this->repository instanceof AddonRepository) {
            $collection = collect();
            if ($this->container->isInstalled()) {
                collect($this->file->directories($this->getExtensionPath()))->each(function ($vendor) use ($collection) {
                    collect($this->file->directories($vendor))->each(function ($directory) use ($collection) {
                        $collection->push($directory);
                    });
                });
            }
            $this->repository = new AddonRepository($collection);
            $this->repository->initialize();
        }

        return $this->repository;
    }

    /**
     * Extension list.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getExtensions(): Collection
    {
        if ($this->extensions->isEmpty() && $this->container->isInstalled()) {
            if ($this->file->isDirectory($this->getExtensionPath())) {
                collect($this->file->directories($this->getExtensionPath()))->each(function ($vendor) {
                    collect($this->file->directories($vendor))->each(function ($directory) {
                        if ($this->file->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                            $package = collect(json_decode($this->file->get($file), true));
                            $configurations = $this->loadConfigurations($directory);
                            if ($package->get('type') == 'notadd-extension'
                                && $package->get('name') == $configurations->get('identification')
                                && ($extension = new Addon($configurations->toArray()))->validate()) {
                                $autoload = collect([
                                    $directory,
                                    'vendor',
                                    'autoload.php',
                                ])->implode(DIRECTORY_SEPARATOR);
                                if ($this->file->exists($autoload)) {
                                    $this->file->requireOnce($autoload);
                                }
                                $extension->offsetExists('provider')
                                || collect(data_get($package, 'autoload.psr-4'))->each(function ($entry, $namespace) use ($extension) {
                                    $extension->offsetSet('namespace', $namespace);
                                    $extension->offsetSet('provider', $namespace . 'Extension');
                                });
                                $extension->offsetSet('directory', $directory);
                                $provider = $extension->offsetGet('provider');
                                if (class_exists($provider)) {
                                    $extension->offsetSet('enabled',
                                        $this->container->make('setting')->get('extension.' . $extension->offsetGet('identification') . '.enabled', false));
                                    $extension->offsetSet('installed',
                                        $this->container->make('setting')->get('extension.' . $extension->offsetGet('identification') . '.installed', false));
                                    $this->extensions->put($configurations->get('identification'), $extension);
                                } else {
                                    $this->unloaded->put($configurations->get('identification'), [
                                        'author'         => $extension->offsetGet('author'),
                                        'description'    => $extension->offsetGet('description'),
                                        'directory'      => $extension->offsetGet('directory'),
                                        'identification' => $extension->offsetGet('identification'),
                                        'provider'       => $extension->offsetGet('provider'),
                                    ]);
                                }
                            }
                        }
                    });
                });
            }
        }

        return $this->extensions;
    }

    /**
     * Path for extension.
     *
     * @return string
     */
    public function getExtensionPath(): string
    {
        return $this->container->addonPath();
    }

    /**
     * @param string $directory
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    protected function loadConfigurations(string $directory): Collection
    {
        if ($this->file->exists($file = $directory . DIRECTORY_SEPARATOR . 'configuration.yaml')) {
            return collect(Yaml::parse(file_get_contents($file)));
        } else {
            if ($this->file->isDirectory($directory = $directory . DIRECTORY_SEPARATOR . 'configurations')) {
                $configurations = collect();
                collect($this->file->files($directory))->each(function ($file) use ($configurations) {
                    if ($this->file->isReadable($file)) {
                        collect(Yaml::dump(file_get_contents($file)))->each(function ($data, $key) use ($configurations) {
                            $configurations->put($key, $data);
                        });
                    }
                });

                return $configurations;
            } else {
                throw new \Exception('Load Extension fail: ' . $directory);
            }
        }
    }

    /**
     * Modules of installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getInstalledExtensions(): Collection
    {
        $list = new Collection();
        if ($this->getExtensions()->isNotEmpty()) {
            $this->extensions->each(function (Addon $extension) use ($list) {
                $extension->isInstalled() && $list->put($extension->identification(), $extension);
            });
        }

        return $list;
    }

    /**
     * Modules of not-installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNotInstalledExtensions(): Collection
    {
        $list = new Collection();
        if ($this->getExtensions()->isNotEmpty()) {
            $this->extensions->each(function (Addon $extension) use ($list) {
                $extension->isInstalled() || $list->put($extension->identification(), $extension);
            });
        }

        return $list;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getUnloadedExtensions(): Collection
    {
        return $this->unloaded;
    }

    /**
     * Check for extension exist.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name): bool
    {
        return $this->extensions->has($name);
    }

    /**
     * Vendor Path.
     *
     * @return string
     */
    public function getVendorPath(): string
    {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'vendor';
    }

    /**
     * @return array
     */
    public function getExcepts()
    {
        return $this->excepts->toArray();
    }

    /**
     * @param $excepts
     */
    public function registerExcept($excepts)
    {
        foreach ((array)$excepts as $except) {
            $this->excepts->push($except);
        }
    }
}
