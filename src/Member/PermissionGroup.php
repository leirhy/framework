<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-03 18:22
 */
namespace Notadd\Foundation\Member;

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
    private $attributes;

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
     * @param string $key
     * @param array  $attributes
     */
    public function permission(string $key, array $attributes)
    {
        Permission::validate($attributes) && $this->permissions->put($key, '');
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public static function validate(array $attributes)
    {
        return true;
    }
}
