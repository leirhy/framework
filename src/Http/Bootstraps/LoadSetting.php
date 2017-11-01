<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-24 10:15
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Http\Contracts\Bootstrap;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class LoadSetting.
 */
class LoadSetting implements Bootstrap
{
    use Helpers;

    /**
     * Bootstrap the given application.
     */
    public function bootstrap()
    {
        if ($this->container->isInstalled()) {
            $this->config->set('app.debug', $this->setting->get('debug.enabled', true));
            $this->config->set('mail.driver', $this->setting->get('mail.driver', 'smtp'));
            $this->config->set('mail.host', $this->setting->get('mail.host'));
            $this->config->set('mail.port', $this->setting->get('mail.port'));
            $this->config->set('mail.from.address', $this->setting->get('mail.from'));
            $this->config->set('mail.from.name', $this->setting->get('site.title', 'Notadd'));
            $this->config->set('mail.encryption', $this->setting->get('mail.encryption'));
            $this->config->set('mail.username', $this->setting->get('mail.username'));
            $this->config->set('mail.password', $this->setting->get('mail.password'));
        }
    }
}
