<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 13:29
 */
namespace Notadd\Foundation\Facades;

use Illuminate\Container\Container;
use Notadd\Foundation\AliasLoader;

/**
 * Class FacadeRegister.
 */
class FacadeRegister
{
    /**
     * @var \Notadd\Foundation\AliasLoader
     */
    protected $aliasLoader;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * FacadeRegister constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Illuminate\Container\Container $container
     * @param \Notadd\Foundation\AliasLoader                                               $aliasLoader
     */
    public function __construct(Container $container, AliasLoader $aliasLoader)
    {
        $this->aliasLoader = $aliasLoader;
        $this->container = $container;
    }
}
