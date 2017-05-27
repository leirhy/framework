<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-17 18:33
 */
namespace Notadd\Foundation\Setting\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class GetHandler.
 */
class GetHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * GetHandler constructor.
     *
     * @param Container $container
     * @param SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->success()->withData([
            'beian' => $this->settings->get('site.beian', ''),
            'company' => $this->settings->get('site.company', ''),
            'copyright' => $this->settings->get('site.copyright', ''),
            'domain' => $this->settings->get('site.domain', ''),
            'enabled' => $this->settings->get('site.enabled', true),
            'name' => $this->settings->get('site.name', ''),
            'statistics' => $this->settings->get('site.statistics', ''),
        ])->withMessage('获取配置项成功！');
    }
}
