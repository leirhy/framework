<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-22 17:53
 */
namespace Notadd\Foundation\Addon\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Addon\Addon;
use Notadd\Foundation\Addon\AddonManager;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class ExtensionHandler.
 */
class AddonHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Module\ModuleManager
     */
    protected $manager;

    /**
     * ExtensionHandler constructor.
     *
     * @param \Illuminate\Container\Container       $container
     * @param \Notadd\Foundation\Addon\AddonManager $manager
     */
    public function __construct(Container $container, AddonManager $manager)
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
        $this->withCode(200)->withData($this->manager->getExtensions()->transform(function (Addon $extension) {
            return [
                'author'         => $extension->getAuthor(),
                'enabled'        => $extension->enabled(),
                'description'    => $extension->getDescription(),
                'identification' => $extension->getIdentification(),
                'name'           => $extension->getName(),
            ];
        })->toArray())->withMessage('获取插件列表成功！');
    }
}
