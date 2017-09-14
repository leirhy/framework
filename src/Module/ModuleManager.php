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
use Illuminate\Contracts\Config\Repository;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

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
     * @var \Illuminate\Support\Collection
     */
    protected $excepts;

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
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $configuration;

    /**
     * ModuleManager constructor.
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Illuminate\Contracts\Config\Repository $configuration
     * @param \Illuminate\Events\Dispatcher           $events
     * @param \Illuminate\Filesystem\Filesystem       $files
     */
    public function __construct(Container $container, Repository $configuration, Dispatcher $events, Filesystem $files) {
        $this->configuration = $configuration;
        $this->container = $container;
        $this->events = $events;
        $this->excepts = collect();
        $this->files = $files;
        $this->modules = collect();
        $this->unloaded = collect();
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
        $list = collect();
        if ($this->getModules()->isNotEmpty()) {
            $this->getModules()->each(function (Module $module) use ($list) {
                $module->offsetGet('enabled') && $list->put($module->identification(), $module);
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
                        $configurations = $this->loadConfigurations($directory);
                        $package = collect(json_decode($this->files->get($file), true));
                        if ($package->get('type') == 'notadd-module'
                            && $configurations->get('identification') == $package->get('name')
                            && ($module = new Module($configurations->toArray()))->validate()) {
                            $autoload = collect([
                                $directory,
                                'vendor',
                                'autoload.php',
                            ])->implode(DIRECTORY_SEPARATOR);
                            if ($this->files->exists($autoload)) {
                                $this->files->requireOnce($autoload);
                            }
                            if (!$module->offsetExists('service')) {
                                collect(data_get($package, 'autoload.psr-4'))->each(function ($entry, $namespace) use (
                                    $module
                                ) {
                                    $module->offsetSet('service', $namespace . 'ModuleServiceProvider');
                                });
                            }
                            $module->offsetSet('directory', $directory);
                            $provider = $module->offsetGet('service');
                            if (class_exists($provider)) {
                                $module->offsetSet('enabled',
                                    $this->container->make('setting')->get('module.' . $module->offsetGet('identification') . '.enabled',
                                        false));
                                $module->offsetSet('installed',
                                    $this->container->make('setting')->get('module.' . $module->offsetGet('identification') . '.installed',
                                        false));
                                $this->modules->put($configurations->get('identification'), $module);
                            } else {
                                $this->unloaded->put($configurations->get('identification'), [
                                    'author'         => $module->get('author'),
                                    'description'    => $module->get('description'),
                                    'directory'      => $module->get('directory'),
                                    'identification' => $module->get('identification'),
                                    'service'        => $module->get('service'),
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
     * Module path.
     *
     * @return string
     */
    public function getModulePath(): string
    {
        return $this->container->basePath() . DIRECTORY_SEPARATOR . $this->configuration->get('module.directory');
    }

    /**
     * @param string $directory
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    protected function loadConfigurations(string $directory)
    {
        if ($this->files->exists($file = $directory . DIRECTORY_SEPARATOR . 'configuration.yaml')) {
            return collect(Yaml::parse(file_get_contents($file)));
        } else {
            if ($this->files->isDirectory($directory = $directory . DIRECTORY_SEPARATOR . 'configurations')) {
                $configurations = collect();
                collect($this->files->files($directory))->each(function ($file) use ($configurations) {
                    if ($this->files->isReadable($file)) {
                        collect(Yaml::dump(file_get_contents($file)))->each(function ($data, $key) use ($configurations
                        ) {
                            $configurations->put($key, $data);
                        });
                    }
                });

                return $configurations;
            } else {
                throw new \Exception('Load Module fail: ' . $directory);
            }
        }
    }

    /**
     * Modules of installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getInstalledModules()
    {
        $list = collect();
        if ($this->getModules()->isNotEmpty()) {
            $this->modules->each(function (Module $module) use ($list) {
                $module->offsetGet('installed') && $list->put($module->identification(), $module);
            });
        }

        return $list;
    }

    /**
     * Modules of not-installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNotInstalledModules()
    {
        $list = collect();
        if ($this->getModules()->isNotEmpty()) {
            $this->modules->each(function (Module $module) use ($list) {
                $module->offsetGet('installed') || $list->put($module->identification(), $module);
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
