<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-25 16:51
 */
namespace Notadd\Foundation\Administration\Controllers;

use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class MenuController.
 */
class MenuController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $configurations = collect((array)json_decode($this->setting->get('administration.menus', ''), true));
        $collection = collect();
        $this->module->repository()->enabled()->map(function (Module $module) use ($configurations, $collection) {
            collect((array)$module->get('menus', []))->each(function ($definition, $identification) use ($configurations, $collection) {
                $configuration = $configurations->get($identification);
                $definition['identification'] = $identification;
                if (is_array($configuration)) {
                    $definition['order'] = isset($configuration['order']) ? intval($configuration['order']) : 0;
                    $definition['show'] = isset($configuration['show']) ? boolval($configuration['show']) : true;
                } else {
                    $definition['order'] = 0;
                    $definition['show'] = true;
                }
                $collection->put($identification, $definition);
            });
        });

        return $this->response->json([
            'data'      => $this->module->menus()->structures()->toArray(),
            'message'   => '获取菜单数据成功！',
            'originals' => $this->module->menus()->toArray(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $data = $this->request->input('data');
        foreach ($data as $key=>$value) {
            unset($data[$key]['icon']);
            unset($data[$key]['parent']);
            unset($data[$key]['expand']);
            unset($data[$key]['path']);
            unset($data[$key]['permission']);
        }
        $this->setting->set('administration.menus', json_encode($data));

        return $this->response->json([
            'message' => '批量更新数据成功！',
        ]);
    }
}
