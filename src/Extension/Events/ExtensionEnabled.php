<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-03 14:25
 */
namespace Notadd\Foundation\Extension\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Extension\Extension;
use Notadd\Foundation\Extension\ExtensionManager;

/**
 * Class ExtensionEnabled.
 */
class ExtensionEnabled
{
    /**
     * @var \Illuminate\Container\Container|\Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Extension\Extension
     */
    protected $extension;

    /**
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;

    /**
     * ExtensionEnabled constructor.
     *
     * @param \Illuminate\Container\Container|\Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $container
     * @param \Notadd\Foundation\Extension\ExtensionManager                                                               $manager
     * @param \Notadd\Foundation\Extension\Extension                                                                      $extension
     */
    public function __construct(Container $container, ExtensionManager $manager, Extension $extension)
    {
        $this->container = $container;
        $this->extension = $extension;
        $this->manager = $manager;
    }
}
