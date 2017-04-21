<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-17 18:33
 */
namespace Notadd\Foundation\Setting\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class GetHandler.
 */
class GetHandler extends DataHandler
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
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return [
            'beian' => $this->settings->get('site.beian', ''),
            'company' => $this->settings->get('site.company', ''),
            'copyright' => $this->settings->get('site.copyright', ''),
            'domain' => $this->settings->get('site.domain', ''),
            'enabled' => $this->settings->get('site.enabled', true),
            'name' => $this->settings->get('site.name', ''),
            'statistics' => $this->settings->get('site.statistics', ''),
        ];
    }
}
