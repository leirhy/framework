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
     * Determines if Intervention Imagecache is installed
     *
     * @return bool
     */
    private function cacheIsInstalled()
    {
        return class_exists('Notadd\\Image\\ImageCache');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->cacheIsInstalled() ? $this->bootstrapImageCache() : null;
    }

    /**
     * Bootstrap imagecache
     *
     * @return void
     */
    private function bootstrapImageCache()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['image'] = $this->app->share(function () {
            return new ImageManager($this->app['config']->get('image'));
        });
        $this->app->alias('image', 'Notadd\Foundation\Image\ImageManager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'image',
        ];
    }
}
