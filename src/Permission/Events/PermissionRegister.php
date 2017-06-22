<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-03 19:48
 */
namespace Notadd\Foundation\Permission\Events;

use Notadd\Foundation\Permission\PermissionManager;

/**
 * Class PermissionRegister.
 */
class PermissionRegister
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionManager
     */
    protected $permission;

    /**
     * PermissionRegister constructor.
     *
     * @param \Notadd\Foundation\Permission\PermissionManager $permission
     *
     * @internal param \Illuminate\Container\Container $container
     */
    public function __construct(PermissionManager $permission)
    {
        $this->permission = $permission;
    }
}
