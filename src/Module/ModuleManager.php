<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-13 21:05
 */
namespace Notadd\Foundation\Module;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Notadd\Foundation\Configuration\Repository as ConfigurationRepository;

/**
 * Class ModuleManager.
 */
class ModuleManager
{
    /**
     * Container instance.
     *
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $modules;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $unloaded;

    /**
     * @var \Notadd\Foundation\Configuration\Repository
     */
    private $configuration;

    /**
     * ModuleManager constructor.
     *
     * @param \Illuminate\Container\Container             $container
     * @param \Notadd\Foundation\Configuration\Repository $configuration
     * @param \Illuminate\Events\Dispatcher               $events
     * @param \Illuminate\Filesystem\Filesystem           $files
     */
    public function __construct(Container $container, ConfigurationRepository $configuration, Dispatcher $events, Filesystem $files)
    {
        $this->configuration = $configuration;
        $this->container = $container;
        $this->events = $events;
        $this->files = $files;
        $this->modules = new Collection();
        $this->unloaded = new Collection();
    }

    /**
     * Get a module by name.
     *
     * @param $name
     *
     * @return \Notadd\Foundation\Module\Module
     */
    public function get($name)
    {
        return $this->modules->get($name);
    }

    /**
     * Modules of enabled.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEnabledModules()
    {
        $list = new Collection();
        if ($this->getModules()->isNotEmpty()) {
            $this->getModules()->each(function (Module $module) use ($list) {
                $module->enabled() && $list->put($module->identification(), $module);
            });
        }

        return $list;
    }

    /**
     * Modules of installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getInstalledModules()
    {
        $list = new Collection();
        if ($this->getModules()->isNotEmpty()) {
            $this->modules->each(function (Module $module) use ($list) {
                $module->installed() && $list->put($module->identification(), $module);
            });
        }

        return $list;
    }

    /**
     * Modules of list.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModules()
    {
        if ($this->modules->isEmpty()) {
            if ($this->files->isDirectory($this->getModulePath())) {
                collect($this->files->directories($this->getModulePath()))->each(function ($directory) {
                    if ($this->files->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                        $package = new Collection(json_decode($this->files->get($file), true));
                        $identification = Arr::get($package, 'name');
                        $type = Arr::get($package, 'type');
                        if ($type == 'notadd-module' && $identification) {
                            $provider = '';
                            if ($entries = data_get($package, 'autoload.psr-4')) {
                                foreach ($entries as $namespace => $entry) {
                                    $provider = $namespace . 'ModuleServiceProvider';
                                }
                            }
                            if ($this->files->exists($autoload = $directory . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
                                $this->files->requireOnce($autoload);
                            }
                            $authors = Arr::get($package, 'authors');
                            $description = Arr::get($package, 'description');
                            if (class_exists($provider) && class_exists($definition = call_user_func([$provider, 'definition']))) {
                                $module = new Module($identification);
                                $module->setAuthor($authors);
                                $module->setContainer($this->container);
                                $module->setDefinition($this->container->make($definition));
                                $module->setDescription($description);
                                $module->setDirectory($directory);
                                $module->setProvider($provider);
                                $this->modules->put($identification, $module);
                            } else {
                                $this->unloaded->put($identification, [
                                    'authors'        => $authors,
                                    'description'    => $description,
                                    'directory'      => $directory,
                                    'identification' => $identification,
                                    'provider'       => $provider,
                                ]);
                            }
                        }
                    }
                });
            }
        }

        return $this->modules;
    }

    /**
     * Modules of not-installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNotInstalledModules()
    {
        $list = new Collection();
        if ($this->getModules()->isNotEmpty()) {
            $this->modules->each(function (Module $module) use ($list) {
                $module->installed() || $list->put($module->identification(), $module);
            });
        }

        return $list;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getUnloadedModules()
    {
        return $this->unloaded;
    }

    /**
     * Check for module exist.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return $this->modules->has($name);
    }

    /**
     * Module path.
     *
     * @return string
     */
    public function getModulePath(): string
    {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . $this->configuration->get('module.directory');
    }
}
