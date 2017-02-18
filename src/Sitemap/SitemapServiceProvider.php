<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-18 19:54
 */
namespace Notadd\Foundation\Sitemap;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Notadd\Content\Models\Article;

/**
 * Class SitemapServiceProvider.
 */
class SitemapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/../../resources/views/sitemap'), 'sitemap');
        $this->app->make(Dispatcher::class)->listen('kernel.handled', function () {
            $list = (new Article())->newQuery()->orderBy('created_at', 'desc')->take(100)->get();
            $sitemap = $this->app->make('sitemap');
            $list->each(function (Article $article) use ($sitemap) {
                $sitemap->add($this->app->make('url')->to('article/' . $article->getAttribute('id')),
                    $article->getAttribute('updated_at'), 0.8, 'daily', [], $article->getAttribute('title'));
            });
            $sitemap->store('xml', 'sitemap');
        });
    }

    public function register()
    {
        $this->app->singleton('sitemap', function () {
            return new Sitemap($this->app, [
                'use_cache'      => false,
                'cache_key'      => 'notadd_sitemap',
                'cache_duration' => 3600,
                'escaping'       => true,
            ]);
        });
    }
}
