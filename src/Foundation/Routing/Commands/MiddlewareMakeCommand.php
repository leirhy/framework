<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 14:57
 */
namespace Notadd\Foundation\Routing\Commands;

use Carbon\Carbon;
use Illuminate\Routing\Console\MiddlewareMakeCommand as IlluminateMiddlewareMakeCommand;

/**
 * Class MiddlewareMakeCommand.
 */
class MiddlewareMakeCommand extends IlluminateMiddlewareMakeCommand
{
    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../../stubs/routes/middleware.stub';
    }

    /**
     * @param string $stub
     * @param string $name
     *
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyDatetime', Carbon::now()->toDateTimeString(), $stub);
    }
}
