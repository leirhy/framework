<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 14:03
 */
namespace Notadd\Foundation\Event;

use Illuminate\Events\EventServiceProvider as IlluminateEventServiceProvider;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends IlluminateEventServiceProvider
{
    /**
     * Register for service provider.
     */
    public function register()
    {
        parent::register();
    }
}
