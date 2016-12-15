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
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $installed;

    /**
     * @var string
     */
    protected $name;

    /**
     * Module constructor.
     *
     * @param string $name
     * @param string|array $author
     * @param string $description
     */
    public function __construct($name = null, $author = null, $description = null)
    {
        $this->author = $author;
        $this->description = $description;
        $this->name = $name;
    }

    /**
     * @return string|array
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isInstalled() {
        return $this->installed;
    }

    /**
     * @param string|array $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function setName($name)
    {
        $this->name = $name;
    }
}
