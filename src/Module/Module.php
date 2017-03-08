<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-13 21:06
 */
namespace Notadd\Foundation\Module;

/**
 * Class Module.
 */
class Module
{
    /**
     * @var string|array
     */
    protected $author;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $directory;

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
    protected $identification;

    /**
     * @var string
     */
    protected $script;

    /**
     * @var array
     */
    protected $stylesheet;

    /**
     * Module constructor.
     *
     * @param string $name
     */
    public function __construct($name = null)
    {
        $this->identification = $name;
    }

    /**
     * Author of module.
     *
     * @return string|array
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Description of module.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Directory of module.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Entry of module.
     *
     * @return string
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Name of module.
     *
     * @return string
     */
    public function getIdentification()
    {
        return $this->identification;
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
     * Enabled of module.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Module install status.
     *
     * @return bool
     */
    public function isInstalled()
    {
        return $this->installed;
    }

    /**
     * Set module's author.
     *
     * @param string|array $author
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
     * Set module's enabled.
     *
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Set module's description.
     *
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set module's directory.
     *
     * @param string $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    /**
     * Set module's entry.
     *
     * @param string $entry
     */
    public function setEntry(string $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Set module's install status.
     *
     * @param bool $installed
     */
    public function setInstalled(bool $installed)
    {
        $this->installed = $installed;
    }

    /**
     * Set module's name.
     *
     * @param string $identification
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
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
}
