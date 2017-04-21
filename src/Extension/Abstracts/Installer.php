<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Extension\Abstracts;

use Illuminate\Container\Container;

/**
 * Class Installer.
 */
abstract class Installer
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Installer constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return bool
     */
    abstract public function handle();

    /**
     * @return bool
     */
    public function install()
    {
        if (!$this->require()) {
            return false;
        }
        return $this->handle();
    }

    /**
     * @return bool
     */
    abstract public function require();
}
