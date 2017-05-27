<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-30 14:48
 */

namespace Notadd\Foundation\Configuration\Contracts;

/**
 * Interface Loader.
 */
interface Loader
{
    /**
     * Load the given configuration group.
     *
     * @param string $environment
     * @param string $group
     * @param string $namespace
     *
     * @return array
     */
    public function load($environment, $group, $namespace = null);

    /**
     * Determine if the given configuration group exists.
     *
     * @param string $group
     * @param string $namespace
     *
     * @return bool
     */
    public function exists($group, $namespace = null);

    /**
     * Add a new namespace to the loader.
     *
     * @param string $namespace
     * @param string $hint
     *
     * @return void
     */
    public function addNamespace($namespace, $hint);

    /**
     * Returns all registered namespaces with the config loader.
     *
     * @return array
     */
    public function getNamespaces();

    /**
     * Apply any cascades to an array of package options.
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
