<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 14:21
 */
namespace Notadd\Foundation\Passport\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
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
    protected $errors;

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
    protected $messages;

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
        $this->errors = new Collection();
        $this->log = $this->container->make('log');
        $this->messages = new Collection();
        $this->request = $this->container->make('request');
        $this->translator = $this->container->make('translator');
    }

    /**
     * Http code.
     *
     * @return int
     */
    protected function code()
    {
        return $this->code;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    protected function errors()
    {
        return $this->errors->toArray();
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    protected function messages()
    {
        return $this->messages->toArray();
    }

    /**
     * @param int $code
     *
     * @return $this
     */
    protected function withCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param array|string $errors
     *
     * @return $this
     */
    protected function withErrors($errors)
    {
        $this->errors = $this->errors->merge((array)$errors);

        return $this;
    }

    /**
     * @param array|string $messages
     *
     * @return $this
     */
    protected function withMessages($messages)
    {
        $this->messages = $this->messages->merge((array)$messages);

        return $this;
    }
}
