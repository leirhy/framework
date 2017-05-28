<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:38
 */
namespace Notadd\Foundation\Testing\Constraints;

/**
 * Class IsChecked.
 */
class IsChecked extends FormFieldConstraint
{
    /**
     * IsChecked constructor.
     *
     * @param string $selector
     */
    public function __construct($selector)
    {
        $this->selector = $selector;
    }

    /**
     * Get the valid elements.
     *
     * @return string
     */
    protected function validElements()
    {
        return "input[type='checkbox']";
    }

    /**
     * Determine if the checkbox is checked.
     *
     * @param \Symfony\Component\DomCrawler\Crawler|string $crawler
     *
     * @return bool
     */
    public function matches($crawler)
    {
        $crawler = $this->crawler($crawler);

        return !is_null($this->field($crawler)->attr('checked'));
    }

    /**
     * Return the description of the failure.
     *
     * @return string
     */
    protected function getFailureDescription()
    {
        return "the checkbox [{$this->selector}] is checked";
    }

    /**
     * Returns the reversed description of the failure.
     *
     * @return string
     */
    protected function getReverseFailureDescription()
    {
        return "the checkbox [{$this->selector}] is not checked";
    }
}
