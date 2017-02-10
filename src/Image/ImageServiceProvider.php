<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 14:57
 */
namespace Notadd\Foundation\Image;

use Illuminate\Support\ServiceProvider;

/**
 * Class ImageServiceProvider.
 */
class ImageServiceProvider extends ServiceProvider
{
    /**
     * @return bool
     */
    private function cacheIsInstalled()
    {
        return class_exists('Notadd\\Image\\ImageCache');
    }

    public function boot()
    {
        $this->cacheIsInstalled() ? $this->bootstrapImageCache() : null;
    }

    private function bootstrapImageCache()
    {
    }

    public function register()
    {
        $this->app['image'] = $this->app->share(function () {
            return new ImageManager($this->app['config']->get('image'));
        });
        $this->app->alias('image', 'Notadd\Foundation\Image\ImageManager');
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'image',
        ];
    }
}
