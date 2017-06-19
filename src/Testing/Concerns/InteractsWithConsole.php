<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-25 11:34
 */
namespace Notadd\Foundation\Testing\Concerns;

use Illuminate\Contracts\Console\Kernel;

/**
 * Class InteractsWithConsole.
 */
trait InteractsWithConsole
{
    /**
     * The last code returned by Artisan CLI.
     *
     * @var int
     */
    protected $code;

    /**
     * Call artisan command and return code.
     *
     * @param string $command
     * @param array  $parameters
     *
     * @return int
     */
    public function artisan($command, $parameters = [])
    {
        return $this->code = $this->app[Kernel::class]->call($command, $parameters);
    }
}
