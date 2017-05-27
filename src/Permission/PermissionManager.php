<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-03 18:15
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionManager.
 */
class PermissionManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Permission\PermissionGroupManager
     */
    protected $group;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $permissions;

    /**
     * PermissionManager constructor.
     *
     * @param \Illuminate\Container\Container                      $container
     * @param \Notadd\Foundation\Permission\PermissionGroupManager $group
     */
    public function __construct(Container $container, PermissionGroupManager $group)
    {
        $this->container = $container;
        $this->group = $group;
        $this->permissions = new Collection();
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Support\Collection|bool
     */
    public function extend(array $attributes)
    {
        $group = $attributes['module'] . '::' . $attributes['group'];
        $permission = $attributes['module'] . '::' . $attributes['group'] . '::' . $attributes['identification'];
        if (Permission::validate($attributes) && $this->group->exists($group) && !$this->permissions->has($permission)) {
            $this->permissions->put($permission, Permission::createFromAttributes($attributes));

            return true;
        }

        return false;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function permissions()
    {
        return $this->permissions;
    }

    /**
     * @param $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function permissionsForGroup($key)
    {
        list($module, $group) = explode('::', $key);
        return $this->permissions->filter(function (Permission $permission) use ($group, $module) {
            return $permission->module() == $module && $permission->group() == $group;
        });
    }
}
