<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 16:38
 */
namespace Notadd\Foundation\Module\Repositories;

use Illuminate\Support\Collection;

/**
 * Class PageRepository.
 */
class PageRepository extends Collection
{
    /**
     * PageRepository constructor.
     *
     * @param \Illuminate\Support\Collection $items
     */
    public function __construct(Collection $items)
    {
        $this->init($items);
    }

    /**
     * @param \Illuminate\Support\Collection $collection
     */
    protected function init(Collection $collection)
    {
        $collection->each(function ($items, $module) {
            collect($items)->each(function ($definition, $identification) use ($module) {
                $this->items[$module . '/' . $identification] = $definition;
            });
        });
    }
}
