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
        collect($this->items)->each(function ($items, $module) {
            unset($this->items[$module]);
            collect($items)->each(function ($definition, $identification) use ($module) {
                $this->items[$module . '/' . $identification] = $definition;
            });
        });
    }
}
