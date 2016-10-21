<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-19 22:45
 */
define('NOTADD_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
$compiledPath = __DIR__ . '/../storage/bootstraps/compiled.php';
if(file_exists($compiledPath)) {
    require $compiledPath;
}
$application = new \Notadd\Foundation\Application(realpath(__DIR__ . '/../'));
$application->singleton(Illuminate\Contracts\Http\Kernel::class, Notadd\Foundation\Http\Kernel::class);
$application->singleton(Illuminate\Contracts\Console\Kernel::class, Notadd\Foundation\Console\Kernel::class);
$application->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Notadd\Foundation\Exception\Handler::class);
$kernel = $application->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());
$response->send();
$kernel->terminate($request, $response);