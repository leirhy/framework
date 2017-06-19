<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:29
 */
namespace Notadd\Foundation\Testing;

use Exception;

/**
 * Class WithoutMiddleware.
 */
trait WithoutMiddleware
{
    /**
     * Prevent all middleware from being executed for this test class.
     *
     * @throws \Exception
     */
    public function disableMiddlewareForAllTests()
    {
        if (method_exists($this, 'withoutMiddleware')) {
            $this->withoutMiddleware();
        } else {
            throw new Exception('Unable to disable middleware. CrawlerTrait not used.');
        }
    }
}
