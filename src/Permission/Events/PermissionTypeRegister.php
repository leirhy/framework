<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 18:30
 */
namespace Notadd\Foundation\Permission\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Permission\PermissionTypeManager;

/**
 * Class PermissionTypeRegister.
 */
class PermissionTypeRegister
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Permission\PermissionTypeManager
     */
    private $type;

    /**
     * PermissionRegister constructor.
     *
     * @param \Illuminate\Container\Container                     $container
     * @param \Notadd\Foundation\Permission\PermissionTypeManager $type
     */
    public function __construct(Container $container, PermissionTypeManager $type)
    {
        $this->container = $container;
        $this->type = $type;
    }
}
