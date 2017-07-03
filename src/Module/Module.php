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
     * Author of module.
     *
     * @return array
     */
    public function author()
    {
        return $this->data->get('author');
    }

    /**
     * Data of module.
     *
     * @return \Illuminate\Support\Collection
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Description of module.
     *
     * @return string
     */
    public function description()
    {
        return $this->data->get('description');
    }

    /**
     * Definition for mall.
     *
     * @return \Notadd\Foundation\Module\Abstracts\Definition
     */
    public function definition()
    {
        return $this->data->get('definition');
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

    public function entries($type = '')
    {
        return collect($this->data->get('entries'))->transform(function ($data, $entry) {
            return $entry;
        })->toArray();
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
     * Name of module.
     *
     * @return string
     */
    public function name()
    {
        if (!$this->data->has('name')) {
            $this->definition()->resolve($this->data);
        }

        return $this->data->get('name');
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
     * Scripts for module.
     *
     * @param string $type
     *
     * @return array
     */
    public function scripts(string $type = '')
    {
        if (!$this->data->has('scripts')) {
            $this->definition()->resolve($this->data);
        }

        return collect($this->data->get('scripts', []))->transform(function ($attributes) use ($type) {
            if ($type && $attributes['type'] == $type) {
                return $attributes['scripts'];
            } else {
                return $attributes;
            }
        })->toArray();
    }

    /**
     * Stylesheets for module.
     *
     * @param string $type
     *
     * @return array
     */
    public function stylesheets(string $type = '')
    {
        if (!$this->data->has('stylesheets')) {
            $this->definition()->resolve($this->data);
        }

        return collect($this->data->get('stylesheets', []))->transform(function ($attributes) use ($type) {
            if ($type && $attributes['type'] == $type) {
                return $attributes['stylesheets'];
            } else {
                return $attributes;
            }
        })->toArray();
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
