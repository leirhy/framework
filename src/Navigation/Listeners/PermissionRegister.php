<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 15:13
 */
namespace Notadd\Foundation\Navigation\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionRegister as AbstractPermissionRegister;

/**
 * Class PermissionRegister.
 */
class PermissionRegister extends AbstractPermissionRegister
{
    /**
     * Handle Permission Register.
     */
    public function handle()
    {
        $this->manager->permission('global', [
            'default' => false,
            'description' => '全局导航分组管理权限',
            'identification' => 'navigation.group.manage',
        ]);
        $this->manager->permission('global', [
            'default' => false,
            'description' => '全局导航项管理权限',
            'identification' => 'navigation.item.manage',
        ]);
    }
}
