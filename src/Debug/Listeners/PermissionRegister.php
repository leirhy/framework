<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 15:12
 */
namespace Notadd\Foundation\Debug\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionRegister as AbstractPermissionRegister;

/**
 * Class PermissionRegister.
 */
class PermissionRegister extends AbstractPermissionRegister
{
    /**
     * Handle Permission Registrar.
     */
    public function handle()
    {
        $this->manager->permission('global', [
            'default' => false,
            'description' => '全局调试模式管理权限',
            'identification' => 'debug.manage',
        ]);
    }
}
