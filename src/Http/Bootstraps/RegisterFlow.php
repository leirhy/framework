<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 14:32
 */
namespace Notadd\Foundation\Http\Bootstraps;

use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Flow\Events\FlowRegister;

/**
 * Class RegisterFlow.
 */
class RegisterFlow
{
    /**
     * Bootstrap the given application.
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     *
     * @return void
     */
    public function bootstrap(Application $application)
    {
//        $application->make('events')->dispatch(new FlowRegister($application['flow']));
    }
}
