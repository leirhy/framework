<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-11 10:46
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionType.
 */
class PermissionType
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var \Illuminate\Container\Container
     */
    private $container;

    /**
     * PermissionType constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param array                           $attributes
     */
    public function __construct(Container $container, array $attributes = [])
    {
        $this->container = $container;
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
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
     * @return array
     */
    public function has()
    {
        $data = new Collection();
        $settings = collect($this->container->make('setting')->get('permissions', []));
        $permissionGroups = $this->container->make(PermissionManager::class)->groups();
        $permissionGroups->each(function (PermissionGroup $group) use ($data, $settings) {
            $group->permissions()->each(function (Permission $permission) use ($data, $group, $settings) {
                $identification = $this->identification() . '::' . $group->identification() . '::' . $permission->identification();
                $data->put($identification, $settings->get($identification, []));
            });
        });

        return $data->toArray();
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
