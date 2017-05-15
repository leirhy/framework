<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-10 10:40
 */
namespace Notadd\Foundation\Http\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Http\Middlewares\VerifyCsrfToken;

/**
 * Class CsrfTokenRegister.
 */
class CsrfTokenRegister
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Http\Middlewares\VerifyCsrfToken
     */
    protected $verifier;

    /**
     * CsrfTokenRegister constructor.
     *
     * @param \Illuminate\Container\Container                     $container
     * @param \Notadd\Foundation\Http\Middlewares\VerifyCsrfToken $verifier
     */
    public function __construct(Container $container, VerifyCsrfToken $verifier)
    {
        $this->container = $container;
        $this->verifier = $verifier;
    }

    /**
     * Register except to verifier.
     *
     * @param $excepts
     */
    public function registerExcept($excepts)
    {
        $this->verifier->registerExcept($excepts);
    }
}
