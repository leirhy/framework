<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-17 20:20
 */
namespace Notadd\Foundation\Notification;

use Illuminate\Container\Container;

/**
 * Class NotificationTypeManager.
 */
class NotificationTypeManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * NotificationTypeManager constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
