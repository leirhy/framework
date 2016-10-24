<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-13 17:50
 */
namespace Notadd\Foundation\Member\Contracts;
/**
 * Interface Manager
 * @package Notadd\Member\Contracts
 */
interface Factory {
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function create(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function delete(array $data, $force = false);
    /**
     * @param $key
     * @return \Notadd\Foundation\Member\Member
     */
    public function find($key);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function edit(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function store(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Member
     */
    public function update(array $data, $force = false);
    /**
     * @param string $name
     * @return mixed
     */
    public function driver($name = null);
}