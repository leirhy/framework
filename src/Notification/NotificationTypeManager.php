<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-17 20:20
 */
namespace Notadd\Foundation\Notification;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Notification\Abstracts\NotificationType;

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
     * @var \Illuminate\Support\Collection
     */
    protected $types;

    /**
     * NotificationTypeManager constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->types = new Collection();
    }

    /**
     * @param                                                                 $identification
     * @param \Notadd\Foundation\Notification\Abstracts\NotificationType|null $type
     *
     * @return \Notadd\Foundation\Notification\Abstracts\NotificationType
     */
    public function type($identification, NotificationType $type = null)
    {
        if (is_null($type) && $this->types->has($identification)) {
            return $this->types->get($identification);
        } else {
            $this->types->put($identification, $type);

            return $type;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function types()
    {
        return $this->types;
    }
}
