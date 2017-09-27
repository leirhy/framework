<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 17:24
 */
namespace Notadd\Foundation\Module\Repositories;

use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class AssetsRepository.
 */
class AssetsRepository extends Repository
{
    /**
     * Initialize.
     */
    public function initialize()
    {
        collect($this->items)->each(function ($items, $module) {
            unset($this->items[$module]);
            $collection = collect($items);
            $collection->count() && $collection->each(function ($collection, $entry) use ($module) {
                $collection = collect($collection);
                $collection->count() && $collection->each(function ($definition, $identification) use ($entry, $module) {
                    $data = [
                        'entry'          => $entry,
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
    }
}
