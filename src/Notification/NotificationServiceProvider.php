<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-22 13:08
 */
namespace Notadd\Foundation\Notification;

use Illuminate\Notifications\NotificationServiceProvider as IlluminateNotificationServiceProvider;

/**
 * Class NotificationServiceProvider.
 */
class NotificationServiceProvider extends IlluminateNotificationServiceProvider
{
    /**
     * @var \Notadd\Foundation\Application
     */
    protected $app;

    /**
     * Register for service provider.
     */
    public function register()
    {
        parent::register();
        $this->app->singleton('notification.type', function ($app) {
            return new NotificationTypeManager($app);
        });
    }
}
