<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 10:47
 */
namespace Notadd\Foundation\Debug\Listeners;

use Illuminate\Contracts\Console\Kernel;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Http\Events\RequestHandled;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class VendorPublish.
 */
class VendorPublish extends EventSubscriber
{
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

    /**
     * Event handler.
     */
    public function handle()
    {
        if ($this->container->isInstalled()) {
            if ($this->container->make(SettingsRepository::class)->get('debug.enabled', false)) {
                $this->container->make(Kernel::class)->call('vendor:publish', [
                    '--force' => true,
                ]);
            }
        }
    }
}
