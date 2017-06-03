<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:37
 */
namespace Notadd\Foundation\Testing\Constraints;

/**
 * Class HasSource.
 */
class HasSource extends PageConstraint
{
    /**
     * The expected HTML source.
     *
     * @var string
     */
    protected $source;

    /**
     * HasSource constructor.
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Check if the source is found in the given crawler.
     *
     * @param \Symfony\Component\DomCrawler\Crawler|string $crawler
     *
     * @return bool
     */
    protected function matches($crawler)
    {
        $pattern = $this->getEscapedPattern($this->source);

        return preg_match("/{$pattern}/i", $this->html($crawler));
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "the HTML [{$this->source}]";
    }
}
