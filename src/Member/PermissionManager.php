<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-15 18:57
 */

namespace Notadd\Foundation\Member;

class PermissionManager
{
    const PATH_PREFIX = 'permission.paths.';

    // protected $config;
    //
    // public function __construct($config)
    // {
    //     $this->config = $config;
    // }

    /**
     * @param string $key
     * @param string $path
     */
    public function registerFilePath(string $key, string $path)
    {
        if (! app('config')->has(static::PATH_PREFIX . $key)) {
            app('config')->set(static::PATH_PREFIX . $key, $path);
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getFilePath(string $key)
    {
        return app('config')->get(static::PATH_PREFIX . $key, '');
    }

    /**
     * @return array
     */
    public function getFilePaths()
    {
        return app('config')->get(rtrim(static::PATH_PREFIX, '.'), []);
    }
}
