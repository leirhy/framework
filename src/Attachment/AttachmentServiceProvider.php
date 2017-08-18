<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-02 15:55
 */
namespace Notadd\Foundation\Attachment;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Attachment\Listeners\PermissionGroupRegister;
use Notadd\Foundation\Attachment\Listeners\PermissionRegister;
use Notadd\Foundation\Attachment\Listeners\RouteRegister;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class AttachmentServiceProvider.
 */
class AttachmentServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
    }
}
