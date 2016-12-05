<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-20 19:50
 */
namespace Notadd\Foundation;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class EnvironmentDetector.
 */
class EnvironmentDetector
{
    /**
     * Detect the application's current environment.
     *
     * @param \Closure   $callback
     * @param array|null $consoleArgs
     *
     * @return string
     */
    public function detect(Closure $callback, $consoleArgs = null)
    {
        if ($consoleArgs) {
            return $this->detectConsoleEnvironment($callback, $consoleArgs);
        }

        return $this->detectWebEnvironment($callback);
    }

    /**
     * TODO: Method detectWebEnvironment Description
     *
     * @param \Closure $callback
     *
     * @return string
     */
    protected function detectWebEnvironment(Closure $callback)
    {
        return call_user_func($callback);
    }

    /**
     * TODO: Method detectConsoleEnvironment Description
     *
     * @param \Closure $callback
     * @param array    $args
     *
     * @return string
     */
    protected function detectConsoleEnvironment(Closure $callback, array $args)
    {
        if (!is_null($value = $this->getEnvironmentArgument($args))) {
            return head(array_slice(explode('=', $value), 1));
        }

        return $this->detectWebEnvironment($callback);
    }

    /**
     * TODO: Method getEnvironmentArgument Description
     *
     * @param array $args
     *
     * @return string|null
     */
    protected function getEnvironmentArgument(array $args)
    {
        return Arr::first($args, function ($value) {
            return Str::startsWith($value, '--env');
        });
    }
}
