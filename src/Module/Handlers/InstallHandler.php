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
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class InstallHandler.
 */
class InstallHandler extends SetHandler
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
        $this->errors->push($this->translator->trans('安装失败！'));
        $this->manager = $manager;
        $this->messages->push($this->translator->trans('安装成功！'));
    }

    /**
     * Execute handler.
     *
     * @return bool
     */
    public function execute()
    {
        $result = false;
        $module = $this->manager->get($this->request->input('identification'));
        if ($module && method_exists($provider = $module->getEntry(), 'install')) {
            if (($installer = $this->container->make(call_user_func([$provider, 'install']))) instanceof Installer) {
                $installer->setModule($module);
                if ($installer->install()) {
                    $result = true;
                } else {
                    $this->code = 500;
                }
                $this->parseInfo($installer->info());
                $this->container->make('log')->info('install data:', $this->data());
            }
        }

        return $result;
    }

    protected function parseInfo(Collection $data) {
        $data->has('data') && $this->data = collect($data->get('data'));
        $data->has('errors') && $this->errors = collect($data->get('errors'));
        $data->has('messages') && $this->messages = collect($data->get('messages'));
    }
}
