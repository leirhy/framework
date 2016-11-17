<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-02 15:55
 */
namespace Notadd\Foundation\Attachment;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Attachment\Listeners\RouteRegistrar;

/**
 * Class AttachmentServiceProvider.
 */
class AttachmentServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouteRegistrar::class);
    }
}
