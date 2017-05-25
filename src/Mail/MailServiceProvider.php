<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-22 15:23
 */
namespace Notadd\Foundation\Mail;

use Illuminate\Events\Dispatcher;
use Illuminate\Mail\MailServiceProvider as IlluminateMailServiceProvider;
use Illuminate\Mail\Markdown;
use Notadd\Foundation\Mail\Listeners\CsrfTokenRegister;
use Notadd\Foundation\Mail\Listeners\PermissionRegister;
use Notadd\Foundation\Mail\Listeners\RouterRegister;

/**
 * Class MailServiceProvider.
 */
class MailServiceProvider extends IlluminateMailServiceProvider
{
    /**
     * @var \Notadd\Foundation\Application
     */
    protected $app;

    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot service provider.
     */
    public function boot()
    {
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouterRegister::class);
    }

    /**
     * Register the Markdown renderer instance.
     */
    protected function registerMarkdownRenderer()
    {
        $this->app->singleton(Markdown::class, function ($app) {
            $config = $app['config'];

            return new Markdown($app['view'], [
                'theme' => $config->get('mail.markdown.theme', 'default'),
                'paths' => $config->get('mail.markdown.paths', []),
            ]);
        });
    }
}
