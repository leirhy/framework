<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 18:30
 */
namespace Notadd\Foundation\Permission\Events;

use Notadd\Foundation\Permission\PermissionTypeManager;

/**
 * Class PermissionTypeRegister.
 */
class PermissionTypeRegister
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionTypeManager
     */
    private $type;

    /**
     * PermissionRegister constructor.
     *
     * @param \Notadd\Foundation\Permission\PermissionTypeManager $type
     *
     * @internal param \Illuminate\Container\Container $container
     */
    public function __construct(PermissionTypeManager $type)
    {
        $this->type = $type;
    }
}
