<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 16:38
 */
namespace Notadd\Foundation\Module\Repositories;

use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class PageRepository.
 */
class PageRepository extends Repository
{
    /**
     * Initialize.
     */
    public function initialize()
    {
        collect($this->items)->each(function ($items, $module) {
            unset($this->items[$module]);
            collect($items)->each(function ($definition, $identification) use ($module) {
                $key = $module . '/' . $identification;
                $this->items[$key] = $definition;
                collect(data_get($definition, 'tabs'))->each(function ($definition, $tab) use ($key) {
                    $key = $key . '.tabs.' . $tab . '.fields';
                    data_set($this->items, $key, collect(data_get($definition, 'fields'))->map(function ($definition) {
                        $definition['value'] = $this->setting()->get($definition['key'], '');

                        return $definition;
                    })->toArray());
                });
            });
        });
    }
}
