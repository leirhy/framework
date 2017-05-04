<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-03 19:48
 */
namespace Notadd\Foundation\Member\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Member\PermissionManager;

/**
 * Class PermissionRegister.
 */
class PermissionRegister
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Member\PermissionManager
     */
    protected $permission;

    /**
     * PermissionRegister constructor.
     *
     * @param \Illuminate\Container\Container             $container
     * @param \Notadd\Foundation\Member\PermissionManager $permission
     */
    public function __construct(Container $container, PermissionManager $permission)
    {
        $this->container = $container;
        $this->permission = $permission;
    }
}
