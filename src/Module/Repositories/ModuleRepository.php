<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:36
 */
namespace Notadd\Foundation\Module\Repositories;

use Illuminate\Container\Container;
use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class ModuleRepository.
 */
class ModuleRepository extends Repository
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
     * ModuleRepository constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param mixed                           $items
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
