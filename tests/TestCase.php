<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-25 11:58
 */
/**
 * Class TestCase.
 */
abstract class TestCase extends Notadd\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Notadd\Foundation\Application
     */
    public function createApplication()
    {
        $application = new \Notadd\Foundation\Application(realpath(__DIR__.'/../'));
        $application->singleton(Illuminate\Contracts\Http\Kernel::class, Notadd\Foundation\Http\Kernel::class);
        $application->singleton(Illuminate\Contracts\Console\Kernel::class, Notadd\Foundation\Console\Kernel::class);
        $application->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Notadd\Foundation\Exception\Handler::class);
        $application->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $application;
    }
}
