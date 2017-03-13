<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 14:21
 */
namespace Notadd\Foundation\Passport\Abstracts;

use Exception;
use Illuminate\Container\Container;
use Notadd\Foundation\Validation\ValidatesRequests;

/**
 * Class Handler.
 */
abstract class Handler
{
    use ValidatesRequests;

    /**
     * @var int
     */
    protected $code = 200;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Contracts\Logging\Log
     */
    protected $log;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * Handler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->log = $this->container->make('log');
        $this->request = $this->container->make('request');
        $this->translator = $this->container->make('translator');
    }

    /**
     * Http code.
     *
     * @return int
     */
    public function code()
    {
        return $this->code;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }
}
