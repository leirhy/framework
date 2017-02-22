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
     * Modules of installed or not installed.
     *
     * @param bool $installed
     *
     * @return \Illuminate\Support\Collection
     */
    public function getModules($installed = false)
    {
        if ($this->modules->isEmpty()) {
            if ($this->files->isDirectory($this->getModulePath())) {
                collect($this->files->directories($this->getModulePath()))->each(function ($directory) use ($installed) {
                    if ($this->files->exists($file = $directory . DIRECTORY_SEPARATOR . 'composer.json')) {
                        $package = new Collection(json_decode($this->files->get($file), true));
                        $name = Arr::get($package, 'name');
                        $type = Arr::get($package, 'type');
                        if ($type == 'notadd-module' && $name) {
                            $module = new Module($name);
                            $module->setAuthor(Arr::get($package, 'authors'));
                            $module->setDescription(Arr::get($package, 'description'));
                            if ($installed) {
                                $module->setInstalled($installed);
                            }
                            $provider = '';
                            if ($entries = data_get($package, 'autoload.psr-4')) {
                                foreach ($entries as $namespace => $entry) {
                                    $provider = $namespace . 'ModuleServiceProvider';
                                    $module->setEntry($provider);
                                }
                            }
                            method_exists($provider, 'script') && $module->setScript(call_user_func([$provider, 'script']));
                            method_exists($provider, 'stylesheet') && $module->setStylesheet(call_user_func([$provider, 'stylesheet']));
                            if ($this->container->isInstalled()) {
                                $module->setEnabled($this->container->make('setting')->get('module.' . $name . '.enabled', false));
                            } else {
                                $module->setEnabled(false);
                            }
                            $this->modules->put($directory, $module);
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
        return $this->container->basePath() . DIRECTORY_SEPARATOR . 'modules';
    }
}
