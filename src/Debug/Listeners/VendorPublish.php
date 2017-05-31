<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 10:47
 */
namespace Notadd\Foundation\Debug\Listeners;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Http\Events\RequestHandled;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class VendorPublish.
 */
class VendorPublish extends EventSubscriber
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $setting;

    /**
     * VendorPublish constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Illuminate\Events\Dispatcher                           $events
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $setting
     */
    public function __construct(Container $container, Dispatcher $events, SettingsRepository $setting)
    {
        parent::__construct($container, $events);
        $this->setting = $setting;
    }

    /**
     * Name of event.
     *
     * @throws \Exception
     * @return string|object
     */
    protected function getEvent()
    {
        return RequestHandled::class;
    }

    public function handle()
    {
        if ($this->container->isInstalled() && $this->setting->get('debug.enabled', false)) {
            $this->container->make(Kernel::class)->call('vendor:publish', [
                '--force' => true,
            ]);
        }
    }
}
