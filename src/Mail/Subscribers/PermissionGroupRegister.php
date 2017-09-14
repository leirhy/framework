<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 17:48
 */
namespace Notadd\Foundation\Mail\Subscribers;

use Notadd\Foundation\Permission\Abstracts\PermissionGroupRegister as AbstractPermissionGroupRegister;

/**
 * Class PermissionGroupRegister.
 */
class PermissionGroupRegister extends AbstractPermissionGroupRegister
{
    /**
     * Handle Permission Group Register.
     */
    public function handle()
    {
        $this->manager->extend([
            'description'    => '邮件权限定义。',
            'identification' => 'mail',
            'module'         => 'global',
            'name'           => '邮件权限',
        ]);
    }
}
