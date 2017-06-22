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
     * @var \Notadd\Foundation\Extension\ExtensionManager
     */
    protected $manager;

    /**
     * ExtensionEnabled constructor.
     *
     * @param \Notadd\Foundation\Extension\Extension $extension
     *
     * @internal param \Illuminate\Container\Container|\Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $container
     * @internal param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }
}
