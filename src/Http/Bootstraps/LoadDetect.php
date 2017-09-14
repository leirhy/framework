<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-14 20:58
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Application;
use Notadd\Foundation\Http\Contracts\Detector;
//use Notadd\Foundation\Http\Detectors\ListenerDetector;
use Notadd\Foundation\Http\Detectors\SubscriberDetector;

/**
 * Class LoadDetect.
 */
class LoadDetect
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $detectors = [
//        ListenerDetector::class,
        SubscriberDetector::class,
    ];

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $event;

    /**
     * LoadDetect constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher   $event
     */
    public function __construct(Container $container, Dispatcher $event)
    {
        $this->container = $container;
        $this->event = $event;
    }

    /**
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        foreach ($this->detectors as $detector) {
            $detector = $this->container->make($detector);
            $detector instanceof Detector && collect($detector->paths())->each(function ($definition) use ($detector) {
                $collections = $detector->detect($definition['path'], $definition['namespace']);
                foreach ($collections as $collection) {
                    $this->event->subscribe($collection);
                }
            });
        }
    }
}
