<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-30 14:48
 */

namespace Notadd\Foundation\Configuration\Contracts;

/**
 * Interface Loader.
 */
interface Loader
{
    /**
     * TODO: Method load Description
     *
     * @param string $environment
     * @param string $group
     * @param string $namespace
     *
     * @return array
     */
    public function load($environment, $group, $namespace = null);

    /**
     * TODO: Method exists Description
     *
     * @param string $group
     * @param string $namespace
     *
     * @return bool
     */
    public function exists($group, $namespace = null);

    /**
     * TODO: Method addNamespace Description
     *
     * @param string $namespace
     * @param string $hint
     *
     * @return void
     */
    public function addNamespace($namespace, $hint);

    /**
     * TODO: Method getNamespaces Description
     *
     * @return array
     */
    public function getNamespaces();

    /**
     * TODO: Method cascadePackage Description
     *
     * @param string $environment
     * @param string $package
     * @param string $group
     * @param array  $items
     *
     * @return array
     */
    public function cascadePackage($environment, $package, $group, $items);
}
