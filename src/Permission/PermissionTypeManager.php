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
    }
}
