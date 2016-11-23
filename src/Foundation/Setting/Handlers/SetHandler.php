<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 15:09
 */
namespace Notadd\Foundation\Setting\Handlers;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class SetHandler.
 */
class SetHandler extends AbstractSetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * SetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * @return array
     */
    public function data()
    {
        return $this->settings->all()->toArray();
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            '修改设置失败！',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function execute(Request $request)
    {
        $this->settings->set('site.enabled', $request->input('enabled'));
        $this->settings->set('site.name', $request->input('name'));
        $this->settings->set('site.domain', $request->input('domain'));
        $this->settings->set('site.beian', $request->input('beian'));
        $this->settings->set('site.company', $request->input('company'));
        $this->settings->set('site.copyright', $request->input('copyright'));
        $this->settings->set('site.statistics', $request->input('statistics'));
        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            '修改设置成功!',
        ];
    }
}
