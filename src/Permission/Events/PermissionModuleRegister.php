<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 17:03
 */
namespace Notadd\Foundation\Permission\Events;

use Notadd\Foundation\Permission\PermissionModuleManager;

/**
 * Class PermissionModuleRegister.
 */
class PermissionModuleRegister
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionModuleManager
     */
    protected $module;

    /**
     * PermissionModuleRegister constructor.
     *
     * @param \Notadd\Foundation\Permission\PermissionModuleManager $module
     *
     * @internal param \Illuminate\Container\Container $container
     */
    public function __construct(PermissionModuleManager $module)
    {
        $this->module = $module;
    }
}
