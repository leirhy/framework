<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-22 16:18
 */
namespace Notadd\Foundation\Extension;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Extension\Repositories\ExtensionRepository;

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
    protected $event;

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
     * @param \Illuminate\Events\Dispatcher     $event
     * @param \Illuminate\Filesystem\Filesystem $file
     */
    public function __construct(Container $container, Dispatcher $event, Filesystem $file)
    {
        $this->container = $container;
        $this->event = $event;
        $this->file = $file;
    }

    /**
     * @param $identification
     *
     * @return bool
     */
    public function has($identification)
    {
        return $this->repository()->has($identification);
    }

    /**
     * @return \Notadd\Foundation\Extension\Repositories\ExtensionRepository
     */
    public function repository()
    {
        if (!$this->repository instanceof ExtensionRepository) {
            $this->repository = new ExtensionRepository();
            $this->repository->initialize(collect($this->file->directories($this->getExtensionPath())));
        }

        return $this->repository;
    }

    /**
     * @return string
     */
    protected function getExtensionPath(): string
    {
        return $this->container->extensionPath();
    }
}
