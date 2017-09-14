<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Debug;

use Illuminate\Events\Dispatcher;
use Notadd\Foundation\Debug\Subscribers\PermissionGroupRegister;
use Notadd\Foundation\Debug\Subscribers\PermissionRegister;
use Notadd\Foundation\Debug\Subscribers\RouteRegister;
use Notadd\Foundation\Http\Abstracts\ServiceProvider;

/**
 * Class DebugServiceProvider.
 */
class DebugServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
}
