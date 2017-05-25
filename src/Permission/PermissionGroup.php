<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-03 18:22
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionGroup.
 */
class PermissionGroup
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $permissions;

    /**
     * PermissionGroup constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param array                           $attributes
     */
    public function __construct(Container $container, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->container = $container;
        $this->permissions = new Collection();
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public static function createFromAttributes(array $attributes)
    {
        return new static(Container::getInstance(), $attributes);
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->attributes['description'];
    }

    /**
     * @return string
     */
    public function identification()
    {
        return $this->attributes['identification'];
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->attributes['name'];
    }

    /**
     * @param array  $attributes
     *
     * @return bool
     */
    public function permission(array $attributes)
    {
        if (Permission::validate($attributes)) {
            $this->permissions->put($attributes['identification'], Permission::createFromAttributes($attributes));

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function permissions()
    {
        return $this->permissions;
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public static function validate(array $attributes)
    {
        $needs = [
            'description',
            'identification',
            'name',
        ];
        foreach ($needs as $need) {
            if (!isset($attributes[$need])) {
                return false;
            }
        }

        return true;
    }
}
