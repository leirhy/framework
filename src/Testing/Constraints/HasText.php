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
 * Class HasText.
 */
class HasText extends PageConstraint
{
    /**
     * The expected text.
     *
     * @var string
     */
    protected $text;

    /**
     * HasText constructor.
     *
     * @param string $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Check if the plain text is found in the given crawler.
     *
     * @param \Symfony\Component\DomCrawler\Crawler|string $crawler
     *
     * @return bool
     */
    protected function matches($crawler)
    {
        $pattern = $this->getEscapedPattern($this->text);

        return preg_match("/{$pattern}/i", $this->text($crawler));
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "the text [{$this->text}]";
    }
}
