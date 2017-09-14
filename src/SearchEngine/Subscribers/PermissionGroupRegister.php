<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 17:53
 */
namespace Notadd\Foundation\SearchEngine\Subscribers;

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
            'description'    => '搜索引擎权限定义。',
            'identification' => 'search-engine',
            'module'         => 'global',
            'name'           => '搜索引擎权限',
        ]);
    }
}
