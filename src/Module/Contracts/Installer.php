<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-24 20:56
 */
namespace Notadd\Foundation\Module\Contracts;

/**
 * Interface Installer.
 */
interface Installer
{
    /**
     * Handler install.
     *
     * @return true
     */
    public function install();
}
