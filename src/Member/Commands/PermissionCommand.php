<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-15 18:01
 */

namespace Notadd\Foundation\Member\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Notadd\Foundation\Member\Permission;
use Symfony\Component\Console\Input\InputOption;

class PermissionCommand extends Command
{
    use ConfirmableTrait;

    protected $name = 'permission';

    protected $signature = 'permission 
        {key? : Register permission config file path key.}
        {--path= : From file create permission.}
        {--all : Export all permissions to database} 
        {--force : Force create}';

    protected $description = 'Export Permissions to database';

    /**
     * @var \Notadd\Foundation\Member\PermissionManager
     */
    protected $permissionManager;

    public function __construct()
    {
        parent::__construct();

        $this->permissionManager = app('permission');
    }

    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $permissions = [];

        $key = $this->argument('key');
        if (! empty($key) && ! empty($realPath = $this->permissionManager->getFilePath($key)) && file_exists($realPath)) {
            $permissions = (array) require $realPath;
        }

        $path = $this->option('path');
        if (! empty($path) && file_exists($path)) {
            $permissions = (array) require $path;
        }

        if ($this->option('all')) {
            $permissions = [];
            $paths = $this->permissionManager->getFilePaths();
            foreach ($paths as $path) {
                if (empty($path) || ! file_exists($path)) {
                    continue;
                }

                $permissions = array_merge($permissions, (array) require $path);
            }
        }

        if (empty($permissions) || count($permissions) < 0) {
            $this->info('没有可导入的权限.');
            return;
        }

        $i = 0;

        $frontendPermissions = array_get($permissions, 'frontend', []);
        $adminPermissions = array_get($permissions, 'admin', []);

        // 添加前台权限
        foreach ($frontendPermissions as $frontendPermission) {
            if (! isset($frontendPermission['display_name']) || ! isset($frontendPermission['name']) || empty($frontendPermission['display_name']) || empty($frontendPermission['name'])) {
                continue;
            }

            if (Permission::where('name', $frontendPermission['name'])->count()) {
                continue;
            }

            Permission::addPermission($frontendPermission['name'], $frontendPermission['display_name'], isset($frontendPermission['description']) ? $frontendPermission['description'] : '');
            $i++;
        }

        // 添加后台权限
        foreach ($adminPermissions as $adminPermission) {
            if (! isset($adminPermission['display_name']) || ! isset($adminPermission['name']) || empty($adminPermission['display_name']) || empty($adminPermission['name'])) {
                continue;
            }

            if (Permission::whereAdmin($adminPermission['name'])->count()) {
                continue;
            }

            Permission::addAdminPermission($adminPermission['name'], $adminPermission['display_name'], isset($adminPermission['description']) ? $adminPermission['description'] : '');
            $i++;
        }

        $this->info("导入 {$i} 个权限.");
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],

            ['path', null, InputOption::VALUE_OPTIONAL, 'The path of permissions file to be executed.'],
        ];
    }
}
