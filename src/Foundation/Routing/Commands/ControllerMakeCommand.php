<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-22 14:48
 */
namespace Notadd\Foundation\Routing\Commands;

use Carbon\Carbon;
use Illuminate\Routing\Console\ControllerMakeCommand as IlluminateControllerMakeCommand;

/**
 * Class ControllerMakeCommand.
 */
class ControllerMakeCommand extends IlluminateControllerMakeCommand
{
    /**
     * TODO: Method getStub Description
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('resource')) {
            return __DIR__ . '/../../../../stubs/routes/controller.stub';
        }

        return __DIR__ . '/../../../../stubs/routes/controller.plain.stub';
    }

    /**
     * TODO: Method replaceClass Description
     *
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
