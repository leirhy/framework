<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-30 20:19
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Module\ModuleLoaded;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class LoadModule.
 */
class LoadModule implements Bootstrap
{
    use Helpers;

    /**
     * Bootstrap the given application.
     */
    public function bootstrap()
    {
        if ($this->container->isInstalled()) {
            $this->module->repository()->enabled()->each(function (Module $module) {
                $this->module->registerExcept($module->get('csrf', []));
                collect($module->get('events', []))->each(function ($data, $key) {
                    switch ($key) {
                        case 'subscribes':
                            collect($data)->each(function ($subscriber) {
                                if (class_exists($subscriber)) {
                                    $this->events->subscribe($subscriber);
                                }
                            });
                            break;
                    }
                });
                $providers = collect($this->container->make('config')->get('app.providers'));
                $providers->push($module->service());
                collect($module->get('providers', []))->each(function ($provider) use ($providers) {
                    $providers->push($provider);
                });
                $this->config->set('app.providers', $providers->toArray());
            });
        }
        $this->event->dispatch(new ModuleLoaded());
    }
}
