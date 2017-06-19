<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-26 10:58
 */
namespace Notadd\Foundation\Permission\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Permission\Events\PermissionRegister as PermissionRegisterEvent;
use Notadd\Foundation\Permission\PermissionGroupManager;

/**
 * Class PermissionGroupRegister.
 */
abstract class PermissionGroupRegister extends EventSubscriber
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionManager
     */
    protected $manager;

    /**
     * PermissionRegister constructor.
     *
     * @param \Illuminate\Container\Container                      $container
     * @param \Illuminate\Events\Dispatcher                        $events
     * @param \Notadd\Foundation\Permission\PermissionGroupManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, PermissionGroupManager $manager)
    {
        parent::__construct($container, $events);
        $this->manager = $manager;
    }

    /**
     * Name of event.
     *
     * @throws \Exception
     * @return string|object
     */
    protected function getEvent()
    {
        return PermissionRegisterEvent::class;
    }

    /**
     * Handle Permission Group Register.
     */
    abstract public function handle();
}
