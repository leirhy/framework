<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-22 17:53
 */
namespace Notadd\Foundation\Extension\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Extension\Extension;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class ExtensionHandler.
 */
class ExtensionHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * ExtensionHandler constructor.
     *
     * @param \Illuminate\Container\Container               $container
     * @param \Notadd\Foundation\Extension\ExtensionManager $manager
     */
    public function __construct(Container $container, ExtensionManager $manager)
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
        $this->success()->withData($this->manager->getExtensions()->transform(function (Extension $extension) {
            return [
                'author'         => $extension->getAuthor(),
                'enabled'        => $extension->isEnabled(),
                'description'    => $extension->getDescription(),
                'identification' => $extension->getIdentification(),
                'name'           => $extension->getName(),
            ];
        })->toArray())->withMessage('获取插件列表成功！');
    }
}
