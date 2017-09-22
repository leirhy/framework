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
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Module\Repositories\AssetsRepository;
use Notadd\Foundation\Module\Repositories\MenuRepository;
use Notadd\Foundation\Module\Repositories\ModuleRepository;
use Notadd\Foundation\Module\Repositories\PageRepository;

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
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * @var \Notadd\Foundation\Module\Repositories\ModuleRepository
     */
    protected $repository;

    /**
     * ModuleManager constructor.
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Illuminate\Filesystem\Filesystem       $files
     */
    public function __construct(Container $container, Filesystem $files)
    {
        $this->container = $container;
        $this->excepts = collect();
        $this->file = $files;
    }

    /**
     * @return \Notadd\Foundation\Module\Repositories\ModuleRepository
     */
    public function repository(): ModuleRepository
    {
        if (!$this->repository instanceof ModuleRepository) {
            $this->repository = new ModuleRepository(collect($this->file->directories($this->getModulePath())));
            $this->repository->initialize();
        }

        return $this->repository;
    }

    /**
     * Get a module by name.
     *
     * @param $name
     *
     * @return \Notadd\Foundation\Module\Module
     */
    public function get($name): Module
    {
        return $this->repository->get($name);
    }

    /**
     * Module path.
     *
     * @return string
     */
    public function getModulePath(): string
    {
        return $this->container->modulePath();
    }

    /**
     * Check for module exist.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name): bool
    {
        return $this->repository->has($name);
    }

    /**
     * @return array
     */
    public function getExcepts()
    {
        return $this->excepts->toArray();
    }

    /**
     * @return \Notadd\Foundation\Module\Repositories\MenuRepository
     */
    public function menus(): MenuRepository
    {
        $collection = collect();
        $this->repository->enabled()->each(function (Module $module) use ($collection) {
            $collection->put($module->identification(), $module->get('menus', []));
        });
        $repository = new MenuRepository($collection);
        $repository->initialize();

        return $repository;
    }

    /**
     * @return \Notadd\Foundation\Module\Repositories\PageRepository
     */
    public function pages(): PageRepository
    {
        $collection = collect();
        $this->repository->enabled()->each(function (Module $module) use ($collection) {
            $collection->put($module->identification(), $module->get('pages', []));
        });
        $repository = new PageRepository($collection);
        $repository->initialize();

        return $repository;
    }

    /**
     * @return \Notadd\Foundation\Module\Repositories\AssetsRepository
     */
    public function assets(): AssetsRepository
    {
        $collection = collect();
        $this->repository->enabled()->each(function (Module $module) use ($collection) {
            $collection->put($module->identification(), $module->get('assets', []));
        });
        $repository = new AssetsRepository($collection);
        $repository->initialize();

        return $repository;
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
