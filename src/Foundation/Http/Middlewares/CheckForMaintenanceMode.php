<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:22
 */
namespace Notadd\Foundation\Http\Middlewares;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Notadd\Foundation\Http\Exceptions\MaintenanceModeException;
/**
 * Class CheckForMaintenanceMode
 * @package Notadd\Foundation\Http\Middlewares
 */
class CheckForMaintenanceMode {
    /**
     * @var \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application
     */
    protected $application;
    /**
     * CheckForMaintenanceMode constructor.
     * @param \Illuminate\Contracts\Foundation\Application|\Notadd\Foundation\Application $application
     */
    public function __construct(Application $application) {
        $this->application = $application;
    }
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next) {
        if($this->application->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->application->storagePath() . '/down'), true);
            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }
        return $next($request);
    }
}