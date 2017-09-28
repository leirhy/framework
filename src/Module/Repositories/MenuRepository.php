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
     * @var \Illuminate\Support\Collection
     */
    protected $structures;

    /**
     * Initialize.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function initialize(Collection $data)
    {
        $configuration = json_decode($this->setting->get('administration.menus', ''), true);
        $this->configuration = is_array($configuration) ? $configuration : [];
        if ($this->container->isInstalled()) {
            $this->items = $this->cache->store()->rememberForever('module.menu.repository', function () use ($data) {
                $collection = collect();
                $data->each(function ($definition, $module) use ($collection) {
                    $this->parse($definition, $module, $collection);
                });

                return $collection->toArray();
            });
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
     * @param array                          $items
     * @param string                         $prefix
     * @param \Illuminate\Support\Collection $collection
     */
    private function parse(array $items, string $prefix, Collection $collection)
    {
        collect($items)->each(function ($definition, $key) use ($collection, $prefix) {
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
                $this->parse($definition['children'], $key, $collection);
                unset($definition['children']);
            }
            $collection->put($key, $definition);
        });
    }
}
