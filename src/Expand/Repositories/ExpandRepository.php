<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-19 10:54
 */
namespace Notadd\Foundation\Expand\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class ExpandRepository.
 */
class ExpandRepository extends Collection
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * ExtensionRepository constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param array                           $items
     */
    public function __construct(Container $container, $items = [])
    {
        parent::__construct($items);
        $this->container = $container;
    }

    /**
     * Initialize.
     */
    public function initialize()
    {
        $this->initialized = true;
    }
}
