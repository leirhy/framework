<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-02 16:00
 */
namespace Notadd\Foundation\Module\Handlers;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Module\Abstracts\Uninstaller;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class UninstallHandler.
 */
class UninstallHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * UninstallHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Foundation\Module\ModuleManager $manager
     */
    public function __construct(Container $container, ModuleManager $manager)
    {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('卸载失败！'));
        $this->manager = $manager;
        $this->messages->push($this->translator->trans('卸载成功！'));
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        set_time_limit(0);
        $result = false;
        $module = $this->manager->get($this->request->input('identification'));
        if ($module && method_exists($provider = $module->getEntry(), 'uninstall')) {
            if (($uninstaller = $this->container->make(call_user_func([$provider, 'uninstall']))) instanceof Uninstaller) {
                $uninstaller->setModule($module);
                if ($uninstaller->uninstall()) {
                    $result = true;
                } else {
                    $this->code = 500;
                }
                $this->parseInfo($uninstaller->info());
                $this->container->make('log')->info('uninstall data:', $this->data());
            }
        }

        return $result;
    }

    /**
     * @param \Illuminate\Support\Collection $data
     */
    protected function parseInfo(Collection $data) {
        $data->has('data') && $this->data = collect($data->get('data'));
        $data->has('errors') && $this->errors = collect($data->get('errors'));
        $data->has('messages') && $this->messages = collect($data->get('messages'));
    }
}
