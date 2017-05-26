<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 15:08
 */
namespace Notadd\Foundation\Attachment\Listeners;

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
            'description' => '全局附件管理权限',
            'identification' => 'attachment.manage',
        ]);
    }
}