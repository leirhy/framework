<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-15 18:38
 */
namespace Notadd\Foundation\Theme;

/**
 * Class Theme.
 */
class Theme
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
     * Theme constructor.
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
     * @return bool
     */
    public function getInstalled()
    {
        return $this->installed;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|array $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param bool $installed
     */
    public function setInstalled($installed)
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
