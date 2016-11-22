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
     * @param bool $status
     */
    public function enable($status = true)
    {
        $this->enabled = $status;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar
     */
    public function getRegistrar()
    {
        return $this->registrar;
    }

    /**
     * @return bool
     */
    public function hasAssets()
    {
        return realpath($this->path . '/assets/') !== false;
    }

    /**
     * @return bool
     */
    public function hasMigrations()
    {
        return realpath($this->path . '/migrations/') !== false;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * @param \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar $registrar
     */
    public function setRegistrar(ExtensionRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }
}
