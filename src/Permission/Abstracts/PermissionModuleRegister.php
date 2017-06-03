<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 17:05
 */
namespace Notadd\Foundation\Permission\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Permission\Events\PermissionModuleRegister as PermissionModuleRegisterEvent;
use Notadd\Foundation\Permission\PermissionModuleManager;

/**
 * Class PermissionModuleRegister.
 */
abstract class PermissionModuleRegister extends EventSubscriber
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionModuleManager
     */
    protected $manager;

    /**
     * PermissionModuleRegister constructor.
     *
     * @param \Illuminate\Container\Container                       $container
     * @param \Illuminate\Events\Dispatcher                         $events
     * @param \Notadd\Foundation\Permission\PermissionModuleManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, PermissionModuleManager $manager)
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
        return PermissionModuleRegisterEvent::class;
    }

    /**
     * Handle Permission Register.
     */
    abstract public function handle();
}
