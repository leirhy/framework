<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 12:08
 */
namespace Notadd\Foundation\Module\Repositories;

use Illuminate\Support\Collection;

/**
 * Class MenuRepository.
 */
class MenuRepository extends Collection
{
    /**
     * @var array
     */
    protected $structures = [];

    /**
     * MenuRepository constructor.
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
        $collection->each(function ($definition, $module) {
            $this->parse($definition, $module);
        });
    }

    /**
     * @param $items
     * @param $prefix
     */
    private function parse($items, $prefix)
    {
        collect($items)->each(function ($definition, $key) use ($prefix) {
            $definition['parent'] = $prefix;
            if (isset($definition['children'])) {
                $this->parse($definition['children'], $prefix . '/' . $key);
                unset($definition['children']);
            }
            $this->items[$prefix . '/' . $key] = $definition;
        });
    }
}
