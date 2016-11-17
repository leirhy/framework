<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-24 10:15
 */
namespace Notadd\Foundation\Bootstrap;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class LoadSetting.
 */
class LoadSetting
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     *
     * @return void
     */
    public function bootstrap(Application $application)
    {
        if ($application->isInstalled()) {
            $config = $application->make(ConfigRepository::class);
            $setting = $application->make(SettingsRepository::class);
            date_default_timezone_set($setting->get('setting.timezone', $config['app.timezone']));
            $config->set('app.debug', $setting->get('setting.debug', true));
            $config->set('mail.driver', $setting->get('mail.driver', 'smtp'));
            $config->set('mail.host', $setting->get('mail.host'));
            $config->set('mail.port', $setting->get('mail.port'));
            $config->set('mail.from.address', $setting->get('mail.from'));
            $config->set('mail.from.name', $setting->get('site.title', 'Notadd'));
            $config->set('mail.encryption', $setting->get('mail.encryption'));
            $config->set('mail.username', $setting->get('mail.username'));
            $config->set('mail.password', $setting->get('mail.password'));
        }
    }
}
