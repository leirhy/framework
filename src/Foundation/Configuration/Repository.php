<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-30 14:44
 */
namespace Notadd\Foundation\Configuration;

use ArrayAccess;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Notadd\Foundation\Configuration\Contract\Loader;

/**
 * Class Repository.
 */
class Repository implements ArrayAccess, ConfigContract
{
    /**
     * @var \Notadd\Foundation\Configuration\Contract\Loader
     */
    protected $loader;

    /**
     * Repository constructor.
     *
     * @param \Notadd\Foundation\Configuration\Contract\Loader $loader
     * @param string                                           $environment
     */
    public function __construct(Loader $loader, $environment)
    {
        $this->loader = $loader;
    }

    /**
     * @return bool
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * @return mixed
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * @return void
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @param array|string $key
     * @param mixed        $value
     *
     * @return void
     */
    public function set($key, $value = null)
    {
        // TODO: Implement set() method.
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function prepend($key, $value)
    {
        // TODO: Implement prepend() method.
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function push($key, $value)
    {
        // TODO: Implement push() method.
    }
}