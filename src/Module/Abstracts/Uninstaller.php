<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Foundation\Module\Abstracts;

use Illuminate\Container\Container;

/**
 * Class Uninstaller.
 */
abstract class Uninstaller
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Uninstaller constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    abstract public function handle();

    /**
     * @return mixed
     */
    abstract public function require();

    /**
     * @return bool
     */
    public function uninstall()
    {
        if (!$this->require()) {
            return false;
        }

        return $this->handle();
    }
}