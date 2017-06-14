<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-14 14:07
 */
namespace Notadd\Foundation\Routing\Traits;

/**
 * Trait Flowable.
 */
trait Flowable
{
    /**
     * @return \Notadd\Foundation\Flow\FlowManager
     */
    protected function flow()
    {
        return $this->container->make('flow');
    }
}
