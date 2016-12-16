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
     * Get assign id.
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
     * Set extension enable status.
     *
     * @param bool $status
     */
    public function enable($status = true)
    {
        $this->enabled = $status;
    }

    /**
     * Get extension's id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get extension's path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get extension's registrar.
     *
     * @return \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar
     */
    public function getRegistrar()
    {
        return $this->registrar;
    }

    /**
     *
     *
     * @return bool
     */
    public function hasAssets()
    {
        return realpath($this->path . '/assets/') !== false;
    }

    /**
     * Get extension migrations status.
     *
     * @return bool
     */
    public function hasMigrations()
    {
        return realpath($this->path . '/migrations/') !== false;
    }

    /**
     * Return extension's info in a array.
     *
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * Set extension's registrar.
     *
     * @param \Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar $registrar
     */
    public function setRegistrar(ExtensionRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }
}
