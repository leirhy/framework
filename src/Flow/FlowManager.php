<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-29 16:18
 */
namespace Notadd\Foundation\Flow;

use Illuminate\Container\Container;

/**
 * Class FlowManager.
 */
class FlowManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * FlowManager constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
