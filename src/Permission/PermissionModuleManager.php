<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 16:42
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionModuleManager.
 */
class PermissionModuleManager
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $modules;

    /**
     * PermissionTypeManager constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->modules = new Collection();
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function exists($key)
    {
        return $this->modules->has($key);
    }

    /**
     * @param array  $attributes
     */
    public function extend(array $attributes)
    {
        if (PermissionModule::validate($attributes) && !$this->modules->has($attributes['identification'])) {
            $this->modules->put($attributes['identification'], PermissionModule::createFromAttributes($attributes));
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        return $this->modules();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function modules()
    {
        return $this->modules;
    }
}
