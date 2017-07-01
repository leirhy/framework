<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-13 21:06
 */
namespace Notadd\Foundation\Module;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Module\Abstracts\Definition;

/**
 * Class Module.
 */
class Module
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $data;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Module constructor.
     *
     * @param string $name
     */
    public function __construct($name = null)
    {
        $this->data = new Collection();
        if (is_string($name)) {
            $this->data->put('identification', $name);
        }
    }

    /**
     * Directory of module.
     *
     * @return string
     */
    public function directory()
    {
        return $this->data->get('directory', '');
    }

    /**
     * Status of enabled for module.
     *
     * @return mixed
     */
    public function enabled()
    {
        if (!$this->data->has('enabled')) {
            $this->data->put('enabled', $this->container->make('setting')->get('module.' . $this->data->get('identification') . '.enabled', false));
        }

        return $this->data->get('enabled', false);
    }

    /**
     * Data of module.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Identification for module.
     *
     * @return mixed
     */
    public function identification()
    {
        return $this->data->get('identification', '');
    }

    /**
     * Status of installed for module.
     *
     * @return mixed
     */
    public function installed()
    {
        if (!$this->data->has('installed')) {
            $this->data->put('installed', $this->container->make('setting')->get('module.' . $this->data->get('identification') . '.installed', false));
        }

        return $this->data->get('installed', false);
    }

    /**
     * Provider for module.
     *
     * @return mixed
     */
    public function provider()
    {
        return $this->data->get('provider', '');
    }

    /**
     * Set module's author.
     *
     * @param string|array $author
     */
    public function setAuthor($author)
    {
        $this->data->put('author', collect($author)->transform(function ($value) {
            if (is_array($value))
                return implode(' <', $value) . '>';

            return $value;
        })->toArray());
    }

    /**
     * Set instance for container.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Set module's definition.
     *
     * @param \Notadd\Foundation\Module\Abstracts\Definition $definition
     */
    public function setDefinition(Definition $definition)
    {
        $this->data->put('definition', $definition);
    }

    /**
     * Set module's description.
     *
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->data->put('description', $description);
    }

    /**
     * Set module's directory.
     *
     * @param string $directory
     */
    public function setDirectory(string $directory)
    {
        $this->data->put('directory', $directory);
    }

    /**
     * Set module's enabled.
     *
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->data->put('enabled', $enabled);
    }

    /**
     * Set module's identification.
     *
     * @param string $identification
     */
    public function setIdentification($identification)
    {
        $this->data->put('identification', $identification);
    }

    /**
     * Set module's install status.
     *
     * @param bool $installed
     */
    public function setInstalled(bool $installed)
    {
        $this->data->put('installed', $installed);
    }

    /**
     * Set module's provider.
     *
     * @param string $provider
     */
    public function setProvider(string $provider)
    {
        $this->data->put('provider', $provider);
    }
}
