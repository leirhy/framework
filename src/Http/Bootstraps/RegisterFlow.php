<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 14:32
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Notadd\Foundation\Application;
use Notadd\Foundation\Flow\Events\FlowRegister;
use Notadd\Foundation\Http\Contracts\Bootstrap;

/**
 * Class RegisterFlow.
 */
class RegisterFlow implements Bootstrap
{
    /**
     * Bootstrap the given application.
     *
     * @param \Notadd\Foundation\Application $application
     */
    public function bootstrap(Application $application)
    {
        $application->make('events')->dispatch(new FlowRegister($application['flow']));
    }
}
