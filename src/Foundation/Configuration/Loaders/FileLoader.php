<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-01 14:48
 */
namespace Notadd\Foundation\Configuration\Loaders;

use Illuminate\Filesystem\Filesystem;
use Notadd\Foundation\Configuration\Contracts\Loader as LoaderContract;

/**
 * Class FileLoader.
 */
class FileLoader implements LoaderContract
{
    /**
     * @var string
     */
    protected $defaultPath;

    /**
     * @var array
     */
    protected $exists = [];

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var array
     */
    protected $hints = [];

    /**
     * FileLoader constructor.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param                                   $defaultPath
     */
    public function __construct(Filesystem $files, $defaultPath)
    {
        $this->defaultPath = $defaultPath;
        $this->files = $files;
    }

    /**
     * @param string $namespace
     * @param string $hint
     *
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }

    /**
     * @param string $environment
     * @param string $package
     * @param string $group
     * @param array  $items
     *
     * @return array
     */
    public function cascadePackage($environment, $package, $group, $items)
    {
        $path = $this->getPackagePath($package, $group);
        if ($this->files->exists($path)) {
            $items = array_merge($items, $this->getRequire($path));
        }
        $path = $this->getPackagePath($package, $group, $environment);
        if ($this->files->exists($path)) {
            $items = array_merge($items, $this->getRequire($path));
        }

        return $items;
    }

    /**
     * @param string $group
     * @param string $namespace
     *
     * @return bool
     */
    public function exists($group, $namespace = null)
    {
        $key = $group . $namespace;
        if (isset($this->exists[$key])) {
            return $this->exists[$key];
        }
        $path = $this->getPath($namespace);
        if (is_null($path)) {
            return $this->exists[$key] = false;
        }
        $file = "{$path}/{$group}.php";
        $exists = $this->files->exists($file);

        return $this->exists[$key] = $exists;
    }

    /**
     * @return array
     */
    public function getNamespaces()
    {
        return $this->hints;
    }

    /**
     * @param string $env
     * @param string $package
     * @param string $group
     *
     * @return string
     */
    protected function getPackagePath($package, $group, $env = null)
    {
        $package = strtolower(str_replace('.', '/', $package));
        if (!$env) {
            $file = "{$package}/{$group}.php";
        } else {
            $file = "{$package}/{$env}/{$group}.php";
        }

        return $this->defaultPath . '/' . $file;
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    protected function getPath($namespace)
    {
        if (is_null($namespace)) {
            return $this->defaultPath;
        } elseif (isset($this->hints[$namespace])) {
            return $this->hints[$namespace];
        }
    }

    /**
     * @param  string $path
     *
     * @return mixed
     */
    protected function getRequire($path)
    {
        return $this->files->getRequire($path);
    }

    /**
     * @param string $environment
     * @param string $group
     * @param string $namespace
     *
     * @return array
     */
    public function load($environment, $group, $namespace = null)
    {
        $items = [];
        $path = $this->getPath($namespace);
        if (is_null($path)) {
            return $items;
        }
        $file = "{$path}/{$group}.php";
        if ($this->files->exists($file)) {
            $items = $this->getRequire($file);
        }
        $file = "{$path}/{$environment}/{$group}.php";
        if ($this->files->exists($file)) {
            $items = $this->mergeEnvironment($items, $file);
        }

        return $items;
    }

    /**
     * @param array  $items
     * @param string $file
     *
     * @return array
     */
    protected function mergeEnvironment(array $items, $file)
    {
        return array_replace_recursive($items, $this->getRequire($file));
    }
}