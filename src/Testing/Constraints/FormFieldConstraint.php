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
 * Class FormFieldConstraint.
 */
abstract class FormFieldConstraint extends PageConstraint
{
    /**
     * The name or ID of the element.
     *
     * @var string
     */
    protected $selector;

    /**
     * The expected value.
     *
     * @var string
     */
    protected $value;

    /**
     * FormFieldConstraint constructor.
     *
     * @param string $selector
     * @param mixed  $value
     */
    public function __construct($selector, $value)
    {
        $this->selector = $selector;
        $this->value = (string)$value;
    }

    /**
     * Get the valid elements.
     * Multiple elements should be separated by commas without spaces.
     *
     * @return string
     */
    abstract protected function validElements();

    /**
     * Get the form field.
     *
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     *
     * @throws \PHPUnit_Framework_ExpectationFailedException
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function field(Crawler $crawler)
    {
        $field = $crawler->filter(implode(', ', $this->getElements()));
        if ($field->count() > 0) {
            return $field;
        }
        $this->fail($crawler,
            sprintf('There is no %s with the name or ID [%s]', $this->validElements(), $this->selector));
    }

    /**
     * Get the elements relevant to the selector.
     *
     * @return array
     */
    protected function getElements()
    {
        $name = str_replace('#', '', $this->selector);
        $id = str_replace([
            '[',
            ']',
        ], [
            '\\[',
            '\\]',
        ], $name);

        return collect(explode(',', $this->validElements()))->map(function ($element) use ($name, $id) {
            return "{$element}#{$id}, {$element}[name='{$name}']";
        })->all();
    }
}
