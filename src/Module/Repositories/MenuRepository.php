<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 12:08
 */
namespace Notadd\Foundation\Module\Repositories;

use Carbon\Carbon;
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
     * @var bool
     */
    protected $initialized = false;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $structures;

    /**
     * Initialize.
     */
    public function initialize()
    {
        if (!$this->initialized) {
            if ($this->container->isInstalled() && $this->cache->store()->has('module.menu.repository')) {
                $this->items = $this->cache->store()->get('module.menu.repository', []);
            } else {
                $configuration = json_decode($this->setting->get('administration.menus', ''), true);
                $this->configuration = is_array($configuration) ? $configuration : [];
                collect($this->items)->each(function ($definition, $module) {
                    unset($this->items[$module]);
                    $this->parse($definition, $module);
                });
                $this->container->isInstalled() && $this->cache->store()->put('module.menu.repository', $this->items, (new Carbon())->addHour(10));
            }
            $this->initialized = true;
        }
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
            $this->structures = $collection->sortBy('order');
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
        $definition['children'] = $children->sortBy('order')->toArray();
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
                $definition['enabled'] = isset($this->configuration[$key]['enabled']) ? boolval($this->configuration[$key]['enabled']) : false;
                $definition['order'] = isset($this->configuration[$key]['order']) ? intval($this->configuration[$key]['order']) : 0;
                $definition['text'] = $this->configuration[$key]['text'] ?? $definition['text'];
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
