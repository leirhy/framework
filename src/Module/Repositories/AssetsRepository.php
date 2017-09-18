<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:24
 */
namespace Notadd\Foundation\Module\Repositories;

use Illuminate\Support\Collection;

/**
 * Class AssetsRepository.
 */
class AssetsRepository extends Collection
{
    /**
     * AssetsRepository constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    /**
     * Initialize.
     */
    protected function initialize()
    {
        collect($this->items)->each(function ($items, $module) {
            unset($this->items[$module]);
        });
    }
}
