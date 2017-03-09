<?php
/**
 * Created by PhpStorm.
 * User: twilroad
 * Date: 2017/3/9
 * Time: 下午6:08
 */

namespace Notadd\Foundation\Module\Abstracts;

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
