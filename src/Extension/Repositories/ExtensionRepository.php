<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:50
 */
namespace Notadd\Foundation\Extension\Repositories;

use Illuminate\Container\Container;
use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class ExtensionRepository.
 */
class ExtensionRepository extends Repository
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
        if (!$this->initialized) {
            $this->initialized = true;
        }
    }
}
