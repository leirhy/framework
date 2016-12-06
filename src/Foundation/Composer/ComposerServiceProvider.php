<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 13:18
 */
namespace Notadd\Foundation\Composer;

use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;
use Notadd\Foundation\Composer\Commands\UpdateCommand;

/**
 * Class ComposerServiceProvider.
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * TODO: Method register Description
     */
    public function register()
    {
        $this->app->singleton('composer', function ($app) {
            return new Composer($app['files'], $app['path.base']);
        });
    }

    /**
     * TODO: Method provides Description
     *
     * @return array
     */
    public function provides()
    {
        return ['composer'];
    }
}
