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
        collect($this->items)->each(function ($definition, $module) {
            unset($this->items[$module]);
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
