<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-18 16:38
 */
namespace Notadd\Foundation\Module\Repositories;

use Carbon\Carbon;
use Notadd\Foundation\Http\Abstracts\Repository;

/**
 * Class PageRepository.
 */
class PageRepository extends Repository
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
            if ($this->container->isInstalled() && $this->cache->store()->has('module.page.repository')) {
                $this->items = $this->cache->store()->get('module.page.repository', []);
            } else {
                collect($this->items)->each(function ($items, $module) {
                    unset($this->items[$module]);
                    collect($items)->each(function ($definition, $identification) use ($module) {
                        $key = $module . '/' . $identification;
                        $this->items[$key] = $definition;
                        collect(data_get($definition, 'tabs'))->each(function ($definition, $tab) use ($key) {
                            $key = $key . '.tabs.' . $tab . '.fields';
                            data_set($this->items, $key, collect(data_get($definition, 'fields'))->map(function ($definition) {
                                $setting = $this->setting->get($definition['key'], '');
                                if (isset($definition['format'])) {
                                    switch ($definition['format']) {
                                        case 'boolean':
                                            $definition['value'] = boolval($setting);
                                            break;
                                        default:
                                            $definition['value'] = $setting;
                                            break;
                                    }
                                } else {
                                    $definition['value'] = $setting;
                                }

                                return $definition;
                            })->toArray());
                        });
                    });
                });
                $this->container->isInstalled() && $this->cache->store()->put('module.page.repository', $this->items, (new Carbon())->addHour(10));
            }
            $this->initialized = true;
        }
    }
}
