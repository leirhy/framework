<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:34
 */
namespace Notadd\Foundation\Testing\Concerns;

/**
 * Class InteractsWithContainer.
 */
trait InteractsWithContainer
{
    /**
     * Register an instance of an object in the container.
     *
     * @param string $abstract
     * @param object $instance
     *
     * @return object
     */
    protected function instance($abstract, $instance)
    {
        $this->app->instance($abstract, $instance);

        return $instance;
    }
}
