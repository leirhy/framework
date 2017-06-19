<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 18:29
 */
namespace Notadd\Foundation\Permission\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Permission\Events\PermissionTypeRegister as PermissionTypeRegisterEvent;
use Notadd\Foundation\Permission\PermissionTypeManager;

/**
 * Class PermissionTypeRegister.
 */
abstract class PermissionTypeRegister extends EventSubscriber
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionTypeManager
     */
    protected $manager;

    /**
     * PermissionTypeRegister constructor.
     *
     * @param \Illuminate\Container\Container                     $container
     * @param \Illuminate\Events\Dispatcher                       $events
     * @param \Notadd\Foundation\Permission\PermissionTypeManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, PermissionTypeManager $manager)
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
        return PermissionTypeRegisterEvent::class;
    }

    /**
     * Handle Permission Register.
     */
    abstract public function handle();
}
