<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:39
 */
namespace Notadd\Foundation\Testing\Constraints;

/**
 * Class ReversePageConstraint.
 */
class ReversePageConstraint extends PageConstraint
{
    /**
     * The page constraint instance.
     *
     * @var \Notadd\Foundation\Testing\Constraints\PageConstraint
     */
    protected $pageConstraint;

    /**
     * ReversePageConstraint constructor.
     *
     * @param \Notadd\Foundation\Testing\Constraints\PageConstraint $pageConstraint
     */
    public function __construct(PageConstraint $pageConstraint)
    {
        $this->pageConstraint = $pageConstraint;
    }

    /**
     * Reverse the original page constraint result.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     *
     * @return bool
     */
    public function matches($crawler)
    {
        return !$this->pageConstraint->matches($crawler);
    }

    /**
     * Get the description of the failure.
     * This method will attempt to negate the original description.
     *
     * @return string
     */
    protected function getFailureDescription()
    {
        return $this->pageConstraint->getReverseFailureDescription();
    }

    /**
     * Get a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return $this->pageConstraint->toString();
    }
}
