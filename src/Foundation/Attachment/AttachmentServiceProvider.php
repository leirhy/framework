<?php
/**
 * Created by PhpStorm.
 * User: TwilRoad
 * Date: 2016/11/17 0017
 * Time: 14:41
 */
namespace Notadd\Foundation\Attachment;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Attachment\Listeners\RouteRegistrar;
/**
 * Class AttachmentServiceProvider
 * @package Notadd\Foundation\Attachment
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