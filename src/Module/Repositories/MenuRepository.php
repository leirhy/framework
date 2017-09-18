<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 12:08
 */
namespace Notadd\Foundation\Module\Repositories;

use ArrayAccess;
use Notadd\Foundation\Http\Supports\ArrayAccessAble;

/**
 * Class MenuRepository.
 */
class MenuRepository implements ArrayAccess
{
    use ArrayAccessAble;

    /**
     * @var array
     */
    protected $structures = [];

    /**
     * MenuRepository constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $this->init($items);
    }

    /**
     * @param array $items
     */
    protected function init(array $items)
    {
        collect($items)->each(function ($definition, $module) {
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
