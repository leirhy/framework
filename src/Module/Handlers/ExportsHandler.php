<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-15 17:03
 */

namespace Notadd\Foundation\Module\Handlers;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Foundation\Validation\Rule;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ExportsHandler.
 */
class ExportsHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $module;

    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $setting;

    /**
     * ExportsHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Module\ModuleManager                 $module
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $setting
     */
    public function __construct(Container $container, ModuleManager $module, SettingsRepository $setting)
    {
        parent::__construct($container);
        $this->module = $module;
        $this->setting = $setting;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'modules' => [
                Rule::array(),
                Rule::required(),
            ],
        ], [
            'modules.array'    => '模块数据必须为数组',
            'modules.required' => '模块数据必须填写',
        ]);
        $data = collect();
        collect($this->request->input('modules'))->each(function ($identification) use ($data) {
            $module = $this->module->get($identification);
            $exports = collect();
            if ($module instanceof Module) {
                $exports->put('name', $module->name());
                $exports->put('version', $module->version());
                $exports->put('time', Carbon::now());
                $exports->put('secret', false);
                $exports->put('data', []);
                $exports->put('settings', collect($module->definition()->settings())->map(function ($default, $key) {
                    return $this->setting->get($key, $default);
                }));
                $data->put($identification, $exports);
            }
        });
        $data = $this->container->make(Yaml::class)->dump($data->toArray(), 4);
        $this->withCode(200)->withData([
            'content' => $data,
            'file'    => 'Notadd export ' . Carbon::now()->format('Y-m-d H:i:s') . '.yaml',
        ])->withMessage('导出数据成功！');
    }
}
