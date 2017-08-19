<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-15 12:31
 */
namespace Notadd\Foundation\Module\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Foundation\Validation\Rule;

/**
 * Class DomainHandler.
 */
class DomainHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $setting;

    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    private $module;

    /**
     * DomainHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Module\ModuleManager                 $module
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $setting
     */
    public function __construct(Container $container, ModuleManager $module, SettingsRepository $setting)
    {
        parent::__construct($container);
        $this->setting = $setting;
        $this->module = $module;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'identification' => Rule::required(),
        ], [
            'identification.required' => '模块标识必须填写',
        ]);
        $identification = $this->request->input('identification');
        if ($this->module->has($identification) && $this->module->getInstalledModules()->has($identification)
            || in_array($identification, [
                'notadd/administration',
                'notadd/api',
            ])) {
            $alias = 'module.' . $identification . '.domain.alias';
            $enabled = 'module.' . $identification . '.domain.enabled';
            $host = 'module.' . $identification . '.domain.host';
            $this->setting->set($alias, $this->request->input('alias', ''));
            $this->setting->set($enabled, $this->request->input('enabled', false));
            $this->setting->set($host, $this->request->input('host', ''));
            if ($this->request->input('default', false)) {
                $this->setting->set('module.default', $identification);
            }
            $this->withCode(200)->withMessage('更新模块域名信息成功！');
        } else {
            $this->withCode('500')->withError('更新模块域名信息失败！');
        }
    }
}
