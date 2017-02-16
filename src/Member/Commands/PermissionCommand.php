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

        // 如果没有指定某个权限文件, 就执行导入所有注册的权限文件
        if (! $this->argument('key') && ! $this->option('path')) {
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
        foreach ($permissions as $permission) {
            if (! isset($permission['display_name']) || ! isset($permission['name']) || empty($permission['display_name']) || empty($permission['name'])) {
                continue;
            }

            if (Permission::where('name', $permission['name'])->count()) {
                continue;
            }

            Permission::addPermission($permission['name'], $permission['display_name'], isset($permission['description']) ? $permission['description'] : '');
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
