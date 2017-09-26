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
use Notadd\Foundation\Http\Abstracts\Repository;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class MenuRepository.
 */
class MenuRepository extends Repository
{
    use Helpers;

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $structures;

    /**
     * Initialize.
     */
    public function initialize()
    {
        $configuration = json_decode($this->setting->get('administration.menus', ''));
        $this->configuration = is_array($configuration) ? $configuration : [];
        collect($this->items)->each(function ($definition, $module) {
            unset($this->items[$module]);
            $this->parse($definition, $module);
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function structures()
    {
        if ($this->structures == null) {
            $collection = collect();
            collect($this->items)->each(function ($definition, $index) use ($collection) {
                if (!$this->has($definition['parent']) && $this->module->repository()->has($definition['parent'])) {
                    $this->structure($index, $collection);
                }
            });
            $this->structures = $collection;
        }

        return $this->structures;
    }

    /**
     * @param                                $index
     * @param \Illuminate\Support\Collection $collection
     */
    protected function structure($index, Collection $collection)
    {
        $children = collect();
        collect($this->items)->filter(function ($item) use ($index) {
            return $item['parent'] == $index;
        })->each(function ($definition, $index) use ($children) {
            $this->structure($index, $children);
        });
        $definition = $this->items[$index];
        $definition['children'] = $children->toArray();
        $definition['index'] = $index;
        $collection->put($index, $definition);
    }

    /**
     * @param $items
     * @param $prefix
     */
    private function parse($items, $prefix)
    {
        collect($items)->each(function ($definition, $key) use ($prefix) {
            $key = $prefix . '/' . $key;
            if (isset($this->configuration[$key])) {
                $definition['enabled'] = boolval($this->configuration[$key]['enabled']);
                $definition['order'] = intval($this->configuration[$key]['order']);
            } else {
                $definition['enabled'] = true;
                $definition['order'] = 0;
            }
            $definition['parent'] = $prefix;
            if (isset($definition['children'])) {
                $this->parse($definition['children'], $key);
                unset($definition['children']);
            }
            $this->items[$key] = $definition;
        });
    }
}
