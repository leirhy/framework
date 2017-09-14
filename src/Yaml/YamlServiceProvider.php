<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-03 19:53
 */
namespace Notadd\Foundation\Yaml;

use Notadd\Foundation\Http\Abstracts\ServiceProvider;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlServiceProvider.
 */
class YamlServiceProvider extends ServiceProvider
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
        return ['yaml'];
    }

    /**
     * Register instance.
     */
    public function register() {
        $this->app->singleton('yaml', function () {
            return new Yaml();
        });
    }
}
