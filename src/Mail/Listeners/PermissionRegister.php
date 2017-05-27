<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 15:13
 */
namespace Notadd\Foundation\Mail\Listeners;

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
        $this->manager->extend([
            'default'        => false,
            'description'    => '全局邮件配置管理权限',
            'group'          => 'mail',
            'identification' => 'mail.manage',
            'module'         => 'global',
        ]);
    }
}
