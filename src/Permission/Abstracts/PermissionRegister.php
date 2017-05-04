<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-04 14:11
 */
namespace Notadd\Foundation\Permission\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Permission\Events\PermissionRegister as PermissionRegisterEvent;
use Notadd\Foundation\Permission\PermissionManager;

/**
 * Class PermissionRegister.
 */
abstract class PermissionRegister extends EventSubscriber
{
    /**
     * @var \Notadd\Foundation\Permission\PermissionManager
     */
    protected $manager;

    /**
     * PermissionRegister constructor.
     *
     * @param \Illuminate\Container\Container                 $container
     * @param \Illuminate\Events\Dispatcher                   $events
     * @param \Notadd\Foundation\Permission\PermissionManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, PermissionManager $manager)
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
     * Handle Route Registrar.
     */
    abstract public function handle();
}
