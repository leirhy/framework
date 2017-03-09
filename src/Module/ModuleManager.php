<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-13 21:05
 */
namespace Notadd\Foundation\Module;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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
     * ModuleManager constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Events\Dispatcher     $events
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Container $container, Dispatcher $events, Filesystem $files)
    {
        $this->container = $container;
        $this->events = $events;
        $this->files = $files;
        $this->modules = new Collection();
    }

    /**
     * Modules of enabled.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEnabledModules()
    {
        $list = new Collection();
        if ($this->getModules()->isEmpty()) {
            return $list;
        }
        $this->modules->each(function (Module $module) use ($list) {
            $module->isEnabled() && $list->put($module->getIdentification(), $module);
        });

        return $list;
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
                            $module = new Module($identification);
                            $module->setAuthor(Arr::get($package, 'authors'));
                            $module->setDescription(Arr::get($package, 'description'));
                            $module->setDirectory($directory);
                            $status = $this->container->isInstalled() ? $this->container->make('setting')->get('module.' . $identification . '.enabled', false) : false;
                            $module->setEnabled($status);
                            $provider = '';
                            if ($entries = data_get($package, 'autoload.psr-4')) {
                                foreach ($entries as $namespace => $entry) {
                                    $provider = $namespace . 'ModuleServiceProvider';
                                }
                            }
                            if (!class_exists($provider)) {
                                if ($this->files->exists($autoload = $directory . DIRECTORY_SEPARATOR . 'vendor' .DIRECTORY_SEPARATOR . 'autoload.php')) {
                                    $this->files->requireOnce($autoload);
                                    if (!class_exists($provider)) {
                                        throw new \Exception('Module load fail!');
                                    }
                                } else {
                                    throw new \Exception('Module load fail!');
                                }
                            }
                            $module->setEntry($provider);
                            method_exists($provider, 'description') && $module->setDescription(call_user_func([$provider, 'description']));
                            method_exists($provider, 'name') && $module->setName(call_user_func([$provider, 'name']));
                            method_exists($provider, 'script') && $module->setScript(call_user_func([$provider, 'script']));
                            method_exists($provider, 'stylesheet') && $module->setStylesheet(call_user_func([$provider, 'stylesheet']));
                            $this->modules->put($identification, $module);
                        }
                    }
                });
            }
        }

        return $this->modules;
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
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'modules';
    }
}
