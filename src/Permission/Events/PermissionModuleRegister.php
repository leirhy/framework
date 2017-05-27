<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 17:03
 */
namespace Notadd\Foundation\Permission\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Permission\PermissionModuleManager;

/**
 * Class PermissionModuleRegister.
 */
class PermissionModuleRegister
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Permission\PermissionModuleManager
     */
    protected $module;

    /**
     * PermissionModuleRegister constructor.
     *
     * @param \Illuminate\Container\Container                       $container
     * @param \Notadd\Foundation\Permission\PermissionModuleManager $module
     */
    public function __construct(Container $container, PermissionModuleManager $module)
    {
        $this->container = $container;
        $this->module = $module;
    }
}
