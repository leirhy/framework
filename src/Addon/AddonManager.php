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
     * @var \Illuminate\Support\Collection
     */
    protected $excepts;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * @var \Notadd\Foundation\Extension\Repositories\ExtensionRepository
     */
    protected $repository;

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
        $this->excepts = collect();
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
        return $this->repository()->get($name);
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
     * Path for extension.
     *
     * @return string
     */
    public function getExtensionPath(): string
    {
        return $this->container->addonPath();
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
        return $this->repository()->has($name);
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
