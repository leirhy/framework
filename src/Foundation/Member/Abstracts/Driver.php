<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 19:05
 */
namespace Notadd\Foundation\Member\Abstracts;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Member\Events\MemberCreated;
use Notadd\Foundation\Member\Events\MemberDeleted;
use Notadd\Foundation\Member\Events\MemberEdited;
use Notadd\Foundation\Member\Events\MemberStored;
use Notadd\Foundation\Member\Events\MemberUpdated;
/**
 * Class Driver
 * @package Notadd\Foundation\Member\Abstracts
 */
abstract class Driver {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * Driver constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function __construct(Container $container, Dispatcher $events) {
        $this->container = $container;
        $this->events = $events;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    final public function create(array $data, $force = false) {
        $member = $this->creating($data, $force);
        $this->events->fire(new MemberCreated($this->container, $this, $member));
        return $member;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    abstract protected function creating(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    final public function delete(array $data, $force = false) {
        $member = $this->deleting($data, $force);
        $this->events->fire(new MemberDeleted($this->container, $this, $member));
        return $member;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    abstract protected function deleting(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    final public function edit(array $data, $force = false) {
        $member = $this->editing($data, $force);
        $this->events->fire(new MemberEdited($this->container, $this, $member));
        return $member;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    abstract protected function editing(array $data, $force = false);
    /**
     * @param $key
     * @return \Notadd\Foundation\Member\Member
     */
    final public function find($key) {
        return $this->finding($key);
    }
    /**
     * @param $key
     * @return \Notadd\Foundation\Member\Member
     */
    abstract protected function finding($key);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    final public function store(array $data, $force = false) {
        $member = $this->storing($data, $force);
        $this->events->fire(new MemberStored($this->container, $this, $member));
        return $member;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    abstract protected function storing(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    final public function update(array $data, $force = false) {
        $member = $this->updating($data, $force);
        $this->events->fire(new MemberUpdated($this->container, $this, $member));
        return $member;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    abstract protected function updating(array $data, $force = false);
}