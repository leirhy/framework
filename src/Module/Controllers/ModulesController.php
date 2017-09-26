<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-26 15:32
 */
namespace Notadd\Foundation\Module\Controllers;

use Illuminate\Support\Collection;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ModulesController.
 */
class ModulesController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $enabled = $this->module->repository()->enabled();
        $installed = $this->module->repository()->installed();
        $modules = $this->module->repository();
        $notInstalled = $this->module->repository()->notInstalled();
        $domains = $enabled->map(function (Module $module) {
            $data = [];
            $alias = 'module.' . $module->identification() . '.domain.alias';
            $enabled = 'module.' . $module->identification() . '.domain.enabled';
            $host = 'module.' . $module->identification() . '.domain.host';
            $data['alias'] = $this->setting->get($alias, '');
            $data['default'] = $this->setting->get('module.default', 'notadd/notadd') == $module->identification();
            $data['enabled'] = boolval($this->setting->get($enabled, 0));
            $data['host'] = $this->setting->get($host, '');
            $data['identification'] = $module->identification();
            $data['name'] = $module->offsetGet('name');

            return $data;
        });
        $domains->offsetUnset('notadd/administration');
        $domains->prepend([
            'alias'          => $this->setting->get('module.notadd/administration.domain.alias', ''),
            'default'        => $this->setting->get('module.default', 'notadd/notadd') == 'notadd/administration',
            'enabled'        => boolval($this->setting->get('module.notadd/administration.domain.enabled', 0)),
            'host'           => $this->setting->get('module.notadd/administration.domain.host', ''),
            'identification' => 'notadd/administration',
            'name'           => 'Notadd 后台',
        ], 'notadd/administration');
        $domains->prepend([
            'alias'          => $this->setting->get('module.notadd/api.domain.alias', ''),
            'default'        => $this->setting->get('module.default', 'notadd/notadd') == 'notadd/api',
            'enabled'        => boolval($this->setting->get('module.notadd/api.domain.enabled', 0)),
            'host'           => $this->setting->get('module.notadd/api.domain.host', ''),
            'identification' => 'notadd/api',
            'name'           => 'Notadd API',
        ], 'notadd/api');
        $domains->prepend([
            'alias'          => '/',
            'default'        => $this->setting->get('module.default', 'notadd/notadd') == 'notadd/notadd',
            'enabled'        => boolval($this->setting->get('module.notadd/notadd.domain.enabled', 0)),
            'host'           => $this->setting->get('module.notadd/notadd.domain.host', ''),
            'identification' => 'notadd/notadd',
            'name'           => 'Notadd',
        ], 'notadd/notadd');
        $enabled->forget('notadd/administration');
        $exports = $modules->map(function ($data) {
            return $data;
        });
        $installed->forget('notadd/administration');
        $modules->forget('notadd/administration');
        $notInstalled->forget('notadd/administration');

        return $this->response->json([
            'data'    => [
                'domains'     => $domains->toArray(),
                'enabled'     => $this->info($enabled),
                'exports'     => $this->info($exports),
                'installed'   => $this->info($installed),
                'multidomain' => boolval($this->setting->get('site.multidomain', false)),
                'modules'     => $this->info($modules),
                'notInstall'  => $this->info($notInstalled),
            ],
            'message' => '',
        ]);
    }

    /**
     * Info list.
     *
     * @param \Illuminate\Support\Collection $list
     *
     * @return array
     */
    protected function info(Collection $list)
    {
        $data = new Collection();
        $list->each(function (Module $module) use ($data) {
            $data->put($module->identification(), [
                'author'         => collect($module->offsetGet('author'))->implode(','),
                'enabled'        => boolval($module->offsetGet('enabled')),
                'description'    => $module->offsetGet('description'),
                'identification' => $module->identification(),
                'name'           => $module->offsetGet('name'),
                'version'        => $module->offsetGet('version'),
            ]);
        });

        return $data->toArray();
    }
}
