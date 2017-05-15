<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 14:51
 */
namespace Notadd\Foundation\Bus;

use Illuminate\Bus\BusServiceProvider as IlluminateBusServiceProvider;

/**
 * Class BusServiceProvider.
 */
class BusServiceProvider extends IlluminateBusServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
}
