<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-14 13:59
 */
namespace Notadd\Foundation\Routing\Traits;

/**
 * Trait Settingable.
 */
trait Settingable
{
    /**
     * Get setting instance.
     *
     * @return \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected function setting()
    {
        return $this->container->make('setting');
    }
}
