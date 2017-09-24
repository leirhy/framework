<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-22 18:18
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Application;
use Notadd\Foundation\Extension\Extension;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Http\Contracts\Bootstrap;

/**
 * Class LoadExtension.
 */
class LoadExtension implements Bootstrap
{
    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;

    /**
     * LoadExtension constructor.
     *
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(ExtensionManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        $application->isInstalled() && $this->manager->repository()->each(function (Extension $extension) use ($application) {
            $providers = collect($application->make('config')->get('app.providers'));
            $providers->push($extension->service());
            $application->make('config')->set('app.providers', $providers->toArray());
        });
    }
}
