<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 15:23
 */
namespace Notadd\Foundation\Mail;

use Illuminate\Events\Dispatcher;
use Illuminate\Mail\MailServiceProvider as IlluminateMailServiceProvider;
use Notadd\Foundation\Mail\Listeners\RouterRegistrar;

/**
 * Class MailServiceProvider.
 */
class MailServiceProvider extends IlluminateMailServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @return void
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(RouterRegistrar::class);
    }
}
