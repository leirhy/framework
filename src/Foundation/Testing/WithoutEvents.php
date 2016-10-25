<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-25 11:30
 */
namespace Notadd\Foundation\Testing;
use Exception;
/**
 * Class WithoutEvents
 * @package Notadd\Foundation\Testing
 */
trait WithoutEvents {
    /**
     * Prevent all event handles from being executed.
     * @throws \Exception
     */
    public function disableEventsForAllTests() {
        if(method_exists($this, 'withoutEvents')) {
            $this->withoutEvents();
        } else {
            throw new Exception('Unable to disable middleware. ApplicationTrait not used.');
        }
    }
}