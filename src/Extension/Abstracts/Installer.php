<?php
/**
 * Created by PhpStorm.
 * User: twilroad
 * Date: 2017/3/9
 * Time: 下午5:59
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
