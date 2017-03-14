<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-29 14:07
 */
namespace Notadd\Foundation\Extension;

/**
 * Class Extension.
 */
class Extension
{
    /**
     * @var string|array
     */
    protected $author;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var string
     */
    protected $entry;

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
     * @var string
     */
    protected $script;

    /**
     * @var array
     */
    protected $stylesheet;

    /**
     * @var string
     */
    protected $version;

    /**
     * Extension constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return array|string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getEntry(): string
    {
        return $this->entry;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Script of module.
     *
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Stylesheet of module.
     *
     * @return array
     */
    public function getStylesheet()
    {
        return $this->stylesheet;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isInstalled(): bool
    {
        return $this->installed;
    }

    /**
     * @param array|string $author
     */
    public function setAuthor($author)
    {
        $author = collect($author)->transform(function($value) {
            if(is_array($value))
                return implode(' <', $value) . '>';
            return $value;
        });

        $this->author = $author->toArray();
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @param string $entry
     */
    public function setEntry(string $entry)
    {
        $this->entry = $entry;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @param bool $installed
     */
    public function setInstalled(bool $installed)
    {
        $this->installed = $installed;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * Set module's script.
     *
     * @param string $script
     */
    public function setScript($script)
    {
        $this->script = $script;
    }

    /**
     * Set module's stylesheet.
     *
     * @param array $stylesheet
     */
    public function setStylesheet(array $stylesheet)
    {
        $this->stylesheet = $stylesheet;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }
}
