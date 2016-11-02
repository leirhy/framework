<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-01 17:29
 */
namespace Notadd\Foundation\Member\Abstracts;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
/**
 * Class Manager
 * @package Notadd\Foundation\Member\Abstracts
 */
abstract class Manager {
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var string
     */
    protected $model;
    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;
    /**
     * Manager constructor.
     * @param \Illuminate\Events\Dispatcher $events
     * @param \Illuminate\Routing\Router $router
     */
    public function __construct(Dispatcher $events, Router $router) {
        $this->events = $events;
        $this->router = $router;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function create(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function delete(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function edit(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function find(array $data, $force = false);
    /**
     * @return void
     */
    public function init() {
    }
    /**
     * @param string $model
     */
    public function registerModel($model) {
        $this->model = $model;
    }
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function store(array $data, $force = false);
    /**
     * @param array $data
     * @param bool $force
     * @return mixed
     */
    abstract public function update(array $data, $force = false);
}