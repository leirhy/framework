<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-03 18:15
 */
namespace Notadd\Foundation\Member;

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
     * @var \Illuminate\Support\Collection
     */
    protected $groups;

    /**
     * PermissionManager constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->groups = new Collection();
    }

    /**
     * @param string $key
     * @param array  $attributes
     *
     * @return bool
     */
    public function group(string $key, array $attributes)
    {
        if (PermissionGroup::validate($attributes)) {
            $this->groups->put($key, PermissionGroup::createFromAttributes($attributes));

            return true;
        } else {
            return false;
        }
    }
}