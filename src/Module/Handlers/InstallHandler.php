<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-02 15:34
 */
namespace Notadd\Foundation\Module\Handlers;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Module\Abstracts\Installer;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class InstallHandler.
 */
class InstallHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * InstallHandler constructor.
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Notadd\Foundation\Module\ModuleManager $manager
     */
    public function __construct(Container $container, ModuleManager $manager)
    {
        parent::__construct($container);
        $this->manager = $manager;
    }

    /**
     * Execute handler.
     */
    public function execute()
    {
        $result = false;
        $module = $this->manager->get($this->request->input('identification'));
        if ($module && method_exists($provider = $module->service(), 'install')) {
            if (($installer = $this->container->make(call_user_func([$provider, 'install']))) instanceof Installer) {
                $installer->setModule($module);
                if ($installer->install()) {
                    $result = true;
                } else {
                    $this->code = 500;
                }
                $this->parseInfo($installer->info());
                $this->container->make('log')->info('install data:', $this->data->toArray());
            }
        }
        if ($result) {
            $this->withCode(200)->withMessage('安装模块成功！');
        } else {
            $this->withCode(500)->withError('安装模块失败！');
        }
    }

    protected function parseInfo(Collection $data) {
        $data->has('data') && $this->data = collect($data->get('data'));
        $data->has('errors') && $this->errors = collect($data->get('errors'));
        $data->has('messages') && $this->messages = collect($data->get('messages'));
    }
}
