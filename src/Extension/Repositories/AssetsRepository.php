<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 18:07
 */
namespace Notadd\Foundation\Extension\Repositories;

use Illuminate\Support\Collection;

/**
 * Class AssetsRepository.
 */
class AssetsRepository extends Collection
{
    /**
     * AssetsRepository constructor.
     *
     * @param mixed $items
     */
    public function __construct($items)
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
