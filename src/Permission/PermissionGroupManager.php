<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 20:05
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionGroupManager.
 */
class PermissionGroupManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $groups;

    /**
     * @var \Notadd\Foundation\Permission\PermissionModuleManager
     */
    protected $module;

    /**
     * PermissionTypeManager constructor.
     *
     * @param Container                                             $container
     * @param \Notadd\Foundation\Permission\PermissionModuleManager $module
     */
    public function __construct(Container $container, PermissionModuleManager $module)
    {
        $this->container = $container;
        $this->groups = new Collection();
        $this->module = $module;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function exists($key)
    {
        return $this->groups->has($key);
    }

    /**
     * @param array $attributes
     */
    public function extend(array $attributes)
    {
        $group = $attributes['module'] . '::' . $attributes['identification'];
        $module = $attributes['module'];
        if (PermissionGroup::validate($attributes) && $this->module->exists($module) && !$this->groups->has($group)) {
            $this->groups->put($group, PermissionGroup::createFromAttributes($attributes));
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function groups()
    {
        return $this->groups;
    }

    /**
     * @param $module
     *
     * @return \Illuminate\Support\Collection
     */
    public function groupsForModule($module)
    {
        return $this->groups->filter(function (PermissionGroup $group) use ($module) {
            return $group->module() == $module;
        });
    }
}
