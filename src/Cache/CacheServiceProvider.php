<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-22 13:35
 */
namespace Notadd\Foundation\Cache;

use Illuminate\Cache\CacheServiceProvider as IlluminateCacheServiceProvider;

/**
 * Class CacheServiceProvider.
 */
class CacheServiceProvider extends IlluminateCacheServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
}
