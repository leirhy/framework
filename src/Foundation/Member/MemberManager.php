<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 16:12
 */
namespace Notadd\Foundation\Member;
use Closure;
use Illuminate\Container\Container;
use InvalidArgumentException;
use Notadd\Foundation\Member\Abstracts\Driver;
use Notadd\Foundation\Member\Contracts\Factory as FactoryContract;
/**
 * Class MemberManager
 * @package Notadd\Member
 */
class MemberManager implements FactoryContract {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var array
     */
    protected $drivers = [];
    /**
     * @var string
     */
    protected $default;
    /**
     * MemberManager constructor.
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container) {
        $this->container = $container;
    }
    /**
     * @param string $name
     * @return \Notadd\Foundation\Member\Abstracts\Driver
     */
    public function driver($name = null) {
        is_null($name) && $name = $this->default;
        if(isset($this->drivers[$name])) {
            $driver = $this->container->call($this->drivers[$name], [$this->container]);
            if($driver instanceof Driver) {
                return $driver;
            }
        }
        throw new InvalidArgumentException("Auth guard driver [{$name}] is not defined.");
    }
    /**
     * @param string $driver
     * @param \Closure $callback
     * @return \Notadd\Foundation\Member\MemberManager
     */
    public function extend($driver, Closure $callback) {
        $this->drivers[$driver] = $callback;
        return $this;
    }
    /**
     * @return string
     */
    public function getDefaultDriver() {
        return $this->default;
    }
    /**
     * @param $driver
     * @throws \Exception
     */
    public function setDefaultDriver($driver) {
        $this->default = $driver;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function create(array $data, $force = false) {
        return $this->driver()->create($data, $force);
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function delete(array $data, $force = false) {
        return $this->driver()->delete($data, $force);
    }
    /**
     * @param $key
     * @return \Notadd\Foundation\Member\Member
     */
    public function find($key) {
        return $this->driver()->find($key);
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function edit(array $data, $force = false) {
        return $this->driver()->edit($data, $force);
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function store(array $data, $force = false) {
        return $this->driver()->store($data, $force);
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function update(array $data, $force = false) {
        return $this->driver()->update($data, $force);
    }
}