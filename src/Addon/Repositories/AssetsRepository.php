<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 18:07
 */
namespace Notadd\Foundation\Addon\Repositories;

use Carbon\Carbon;
use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class AssetsRepository.
 */
class AssetsRepository extends Repository
{
    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * Initialize.
     */
    public function initialize()
    {
        if (!$this->initialized) {
            if ($this->container->isInstalled() && $this->cache->store()->has('addon.assets.repository')) {
                $this->items = $this->cache->store()->get('addon.assets.repository');
            } else {
                collect($this->items)->each(function ($items, $module) {
                    unset($this->items[$module]);
                    $collection = collect($items);
                    $collection->count() && $collection->each(function ($collection, $entry) use ($module) {
                        $collection = collect($collection);
                        $collection->count() && $collection->each(function ($definition, $identification) use ($entry, $module) {
                            $data = [
                                'entry'          => $entry,
                                'for'            => 'addon',
                                'identification' => $identification,
                                'module'         => $module,
                                'permission'     => data_get($definition, 'permission', ''),
                            ];
                            collect((array)data_get($definition, 'scripts'))->each(function ($path) use ($data) {
                                $this->items[] = array_merge($data, [
                                    'file' => $path,
                                    'type' => 'script',
                                ]);
                            });
                            collect((array)data_get($definition, 'stylesheets'))->each(function ($path) use ($data) {
                                $this->items[] = array_merge($data, [
                                    'file' => $path,
                                    'type' => 'stylesheet',
                                ]);
                            });
                        });
                    });
                });
                $this->container->isInstalled() && $this->cache->store()->put('addon.assets.repository', $this->items, (new Carbon())->addHour(10));
            }
            $this->initialized = true;
        }
    }
}
