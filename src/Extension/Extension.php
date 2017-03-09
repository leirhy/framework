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
     * @var string
     */
    protected $directory;

    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var string
     */
    protected $entry;

    /**
     * @var string
     */
    protected $identification;

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
     * @param string $identification
     */
    public function __construct($identification)
    {
        $this->identification = $identification;
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
     * Get directory of extension.
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
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
    public function getIdentification(): string
    {
        return $this->identification;
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
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
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
     * Set directory of extension.
     *
     * @param string $directory
     */
    public function setDirectory(string $directory)
    {
        $this->directory = $directory;
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
     * @param string $identification
     */
    public function setIdentification(string $identification)
    {
        $this->identification = $identification;
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
