<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:36
 */
namespace Notadd\Foundation\Testing\Constraints;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class HasInElement.
 */
class HasInElement extends PageConstraint
{
    /**
     * The name or ID of the element.
     *
     * @var string
     */
    protected $element;

    /**
     * The text expected to be found.
     *
     * @var string
     */
    protected $text;

    /**
     * HasInElement constructor.
     *
     * @param string $element
     * @param string $text
     */
    public function __construct($element, $text)
    {
        $this->text = $text;
        $this->element = $element;
    }

    /**
     * Check if the source or text is found within the element in the given crawler.
     *
     * @param \Symfony\Component\DomCrawler\Crawler|string $crawler
     *
     * @return bool
     */
    public function matches($crawler)
    {
        $elements = $this->crawler($crawler)->filter($this->element);
        $pattern = $this->getEscapedPattern($this->text);
        foreach ($elements as $element) {
            $element = new Crawler($element);
            if (preg_match("/$pattern/i", $element->html())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the description of the failure.
     *
     * @return string
     */
    protected function getFailureDescription()
    {
        return sprintf('[%s] contains %s', $this->element, $this->text);
    }

    /**
     * Returns the reversed description of the failure.
     *
     * @return string
     */
    protected function getReverseFailureDescription()
    {
        return sprintf('[%s] does not contain %s', $this->element, $this->text);
    }
}
