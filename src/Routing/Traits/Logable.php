<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-14 14:05
 */
namespace Notadd\Foundation\Routing\Traits;

/**
 * Trait Logable.
 */
trait Logable
{
    /**
     * @return \Psr\Log\LoggerInterface
     */
    protected function logger()
    {
        return $this->container->make('log');
    }
}
