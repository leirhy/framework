<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-23 14:21
 */
namespace Notadd\Foundation\Passport\Abstracts;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Notadd\Foundation\Passport\Responses\ApiResponse;
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
     * @param \Notadd\Foundation\Passport\Responses\ApiResponse $response
     * @param \Exception                                        $exception
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     */
    protected function handleExceptions(ApiResponse $response, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $response->withParams([
                'code'    => 422,
                'message' => $exception->validator->errors()->getMessages(),
                'trace'   => $exception->getTrace(),
            ]);
        }

        return $response->withParams([
            'code'    => $exception->getCode(),
            'message' => $exception->getMessage(),
            'trace'   => $exception->getTrace(),
        ]);
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
