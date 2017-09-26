<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-26 16:04
 */
namespace Notadd\Foundation\Administration\Controllers;

use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class DashboardsController.
 */
class DashboardsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $dashboards = collect();
        $hidden = collect();
        $left = collect();
        $right = collect();
        $this->module->repository()->enabled()->each(function (Module $module) use ($dashboards) {
            $module->offsetExists('dashboards') && collect($module->get('dashboards'))->each(function (
                $definition,
                $identification
            ) use ($dashboards) {
                if (is_string($definition['template'])) {
                    list($class, $method) = explode('@', $definition['template']);
                    if (class_exists($class)) {
                        $instance = $this->container->make($class);
                        $definition['template'] = $this->container->call([
                            $instance,
                            $method,
                        ]);
                    }
                }
                $dashboards->put($identification, $definition);
            });
        });
        $dashboards = $dashboards->keyBy('identification');
        $saved = collect(json_decode($this->setting->get('administration.dashboards', '')));
        $saved->has('hidden') && collect($saved->get('hidden', []))->each(function ($identification) use ($dashboards, $hidden) {
            if ($dashboards->has($identification)) {
                $hidden->push($dashboards->get($identification));
                $dashboards->offsetUnset($identification);
            }
        });
        $saved->has('left') && collect($saved->get('left', []))->each(function ($identification) use ($dashboards, $left) {
            if ($dashboards->has($identification)) {
                $left->push($dashboards->get($identification));
                $dashboards->offsetUnset($identification);
            }
        });
        $saved->has('right') && collect($saved->get('right', []))->each(function ($identification) use ($dashboards, $right) {
            if ($dashboards->has($identification)) {
                $right->push($dashboards->get($identification));
                $dashboards->offsetUnset($identification);
            }
        });
        if ($dashboards->isNotEmpty()) {
            $dashboards->each(function ($definition) use ($left) {
                $left->push($definition);
            });
        }

        return $this->response->json([
            'data'    => [
                'hidden' => $hidden->toArray(),
                'left'   => $left->toArray(),
                'right'  => $right->toArray(),
            ],
            'message' => '获取面板数据成功！',
        ]);
    }
}
