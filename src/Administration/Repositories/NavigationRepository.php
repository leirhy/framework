<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-29 22:34
 */
namespace Notadd\Foundation\Administration\Repositories;

use Illuminate\Support\Collection;
use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class NavigationRepository.
 */
class NavigationRepository extends Repository
{
    /**
     * Initialize.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function initialize(Collection $data)
    {
        if ($this->container->isInstalled()) {
            $this->items = $this->cache->store()->rememberForever('administration.navigation.repository', function () use ($data) {
                return $data->map(function ($definition) {
                    return collect($definition)->map(function ($definition, $key) {
                        if ($key == 'children') {
                            return collect($definition)->map(function ($definition, $key) {
                                if ($key == 'notadd/administration/global/0') {
                                    $children = collect((array)$definition['children']);
                                    $this->administration->pages()->each(function ($definition) use ($children, $key) {
                                        if ($definition['initialization']['target'] == 'global') {
                                            $children->push([
                                                'children' => [],
                                                'parent' => $key,
                                                'path' => $definition['initialization']['path'],
                                                'text' => $definition['initialization']['name'],
                                            ]);
                                        }
                                    });
                                    $definition['children'] = $children->map(function ($definition, $index) {
                                        $definition['index'] = $definition['parent'] . '/' . $index;

                                        return $definition;
                                    })->keyBy('index')->toArray();
                                }

                                return $definition;
                            });
                        } else {
                            return $definition;
                        }
                    });
                })->all();
            });
        }
    }
}
