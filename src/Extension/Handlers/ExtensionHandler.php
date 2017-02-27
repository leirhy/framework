<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-22 17:53
 */
namespace Notadd\Foundation\Extension\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Extension\Extension;
use Notadd\Foundation\Extension\ExtensionManager;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class ExtensionHandler.
 */
class ExtensionHandler extends DataHandler
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
    public function __construct(
        Container $container,
        ExtensionManager $manager
    ) {
        parent::__construct($container);
        $this->manager = $manager;
    }

    /**
     * Http code.
     *
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * Data for handler.
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function data()
    {
        $modules = $this->manager->getExtensions();
        $modules->transform(function (Extension $extension) {
            return [
                'author' => $extension->getAuthor(),
                'enabled' => $extension->isEnabled(),
                'description' => $extension->getDescription(),
                'name' => $extension->getName(),
            ];
        });

        return $modules->toArray();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            '获取全局设置失败！',
        ];
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '获取全局设置成功！',
        ];
    }
}
