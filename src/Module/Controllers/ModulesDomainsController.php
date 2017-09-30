<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-30 16:03
 */
namespace Notadd\Foundation\Module\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Foundation\Validation\Rule;

/**
 * Class ModulesDomainsController.
 */
class ModulesDomainsController extends Controller
{
    /**
     * @var bool
     */
    protected $onlyValues = true;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        list($data) = $this->validate($this->request, [
            'data' => Rule::required(),
        ], [
            'data.required' => '域名数据必须填写',
        ]);
        collect($data)->each(function ($definition) {
            if (isset($definition['identification'])
                && $this->module->has($definition['identification'])
                && $this->module->repository()->installed()->has($definition['identification']) || in_array($definition['identification'], [
                    'notadd/administration',
                    'notadd/api',
                    'notadd/notadd',
                ])) {
                $identification = $definition['identification'];
                $alias = 'module.' . $identification . '.domain.alias';
                $enabled = 'module.' . $identification . '.domain.enabled';
                $host = 'module.' . $identification . '.domain.host';
                $this->setting->set($alias, data_get($definition, 'alias', ''));
                $this->setting->set($enabled, data_get($definition, 'enabled', false));
                $this->setting->set($host, data_get($definition, 'host', ''));
                if (data_get($definition, 'default', false)) {
                    $this->setting->set('module.default', $identification);
                }
            }
        });

        return $this->response->json([
            'message' => '更新模块域名信息成功！',
        ]);
    }
}
