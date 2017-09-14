<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-24 10:07
 */
namespace Notadd\Foundation\Setting;

use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class SettingServiceProvider.
 */
class SettingServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @return array
     */
    public function provides()
    {
        return ['setting'];
    }

    /**
     * Register for service provider.
     */
    public function register()
    {
        $this->app->singleton('setting', function () {
            return new MemoryCacheSettingsRepository(new DatabaseSettingsRepository($this->app->make('db.connection')));
        });
    }
}
