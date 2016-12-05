<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Foundation\Extension;

use Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar;
use Notadd\Foundation\Extension\Contracts\Extension as ExtensionContract;

/**
 * Class Extension.
 */
class Extension implements ExtensionContract
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool
     */
    protected $installed = false;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar
     */
    protected $registrar;

    /**
     * @var string
     */
    protected $version;

    /**
     * Extension constructor.
     *
     * @param string $name
     * @param string $path
     */
    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
        $this->assignId();
    }

    /**
     * @return void
     * TODO: Method assignId Description
     */
    protected function assignId()
    {
        list($vendor, $package) = explode('/', $this->name);
        $package = str_replace([
            'notadd-ext-',
            'notadd-',
        ], '', $package);
        $this->id = "$vendor-$package";
    }

    /**
     * TODO: Method enable Description
     *
     * @param bool $status
     */
    public function enable($status = true)
    {
        $this->enabled = $status;
    }

    /**
     * TODO: Method getId Description
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * TODO: Method getPath Description
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * TODO: Method getRegistrar Description
     *
     * @return \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar
     */
    public function getRegistrar()
    {
        return $this->registrar;
    }

    /**
     * TODO: Method hasAssets Description
     *
     * @return bool
     */
    public function hasAssets()
    {
        return realpath($this->path . '/assets/') !== false;
    }

    /**
     * TODO: Method hasMigrations Description
     *
     * @return bool
     */
    public function hasMigrations()
    {
        return realpath($this->path . '/migrations/') !== false;
    }

    /**
     * TODO: Method toArray Description
     *
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * TODO: Method setRegistrar Description
     *
     * @param \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar $registrar
     */
    public function setRegistrar(ExtensionRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }
}
