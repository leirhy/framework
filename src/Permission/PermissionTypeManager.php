<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 12:41
 */
namespace Notadd\Foundation\Permission;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionTypeManager.
 */
class PermissionTypeManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $types;

    /**
     * PermissionTypeManager constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->types = new Collection();
        $this->initialize();
    }

    /**
     * @param string $identification
     * @param array  $attributes
     */
    public function extend(string $identification, array $attributes)
    {
        if (!$this->types->has($identification) && PermissionType::validate($attributes)) {
            $this->types->put($identification, PermissionType::createFromAttributes($attributes));
        }
    }

    public function initialize()
    {
        $this->types->put('global', PermissionType::createFromAttributes([
            'description' => '全局权限类型。',
            'identification' => 'global',
            'name' => '全局',
        ]));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function types()
    {
        return $this->types;
    }
}
