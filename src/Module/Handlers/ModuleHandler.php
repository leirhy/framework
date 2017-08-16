<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-18 19:03
 */
namespace Notadd\Foundation\Module\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Module\Module;
use Notadd\Foundation\Module\ModuleManager;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class ModuleHandler.
 */
class ModuleHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * ModuleHandler constructor.
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
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->withCode(200)->withData($this->manager->getModules()->transform(function (Module $module) {
            return [
                'author'         => $module->offsetGet('author'),
                'enabled'        => $module->offsetGet('enabled'),
                'description'    => $module->offsetGet('description'),
                'identification' => $module->identification(),
                'name'           => $module->offsetGet('name'),
            ];
        })->toArray())->withMessage('获取模块列表成功！');
    }
}
