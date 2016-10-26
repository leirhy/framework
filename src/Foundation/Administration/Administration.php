<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-25 17:47
 */
namespace Notadd\Foundation\Administration;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Administration\Abstracts\Administrator;
/**
 * Class Administration
 * @package Notadd\Foundation\Administration
 */
class Administration {
    /**
     * @var \Notadd\Foundation\Administration\Abstracts\Administrator
     */
    protected $administrator;
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * Administration constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function __construct(Container $container, Dispatcher $events) {
        $this->container = $container;
        $this->events = $events;
    }
    /**
     * @param $administrator
     */
    public function setAdministrator(Administrator $administrator) {
        if(is_object($this->administrator)) {
            throw new \InvalidArgumentException('Administrator has been Setted!');
        }
        if($administrator instanceof Administrator) {
            $this->administrator = $administrator;
        } else {
            throw new \InvalidArgumentException('Administrator must be instanceof \Notadd\Foundation\Administration\Abstracts\Administrator!');
        }
        $administrator->init();
    }
}