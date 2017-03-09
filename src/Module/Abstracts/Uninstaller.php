<?php
/**
 * Created by PhpStorm.
 * User: twilroad
 * Date: 2017/3/9
 * Time: 下午6:23
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