<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:50
 */
namespace Notadd\Foundation\Extension\Repositories;

use Illuminate\Support\Collection;

/**
 * Class ExtensionRepository.
 */
class ExtensionRepository extends Collection
{
    /**
     * ExtensionRepository constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
        $this->initialize();
    }

    /**
     * Initialize.
     */
    protected function initialize()
    {
    }
}
