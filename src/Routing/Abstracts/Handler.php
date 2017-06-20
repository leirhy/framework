<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-23 14:21
 */
namespace Notadd\Foundation\Routing\Abstracts;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Notadd\Foundation\Passport\Responses\ApiResponse;
use Notadd\Foundation\Permission\PermissionManager;
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
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $data;

    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $database;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $extra;

    /**
     * @var \Notadd\Foundation\Flow\FlowManager
     */
    protected $flow;

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
        $this->data = new Collection();
        $this->database = $this->container->make('db');
        $this->errors = new Collection();
        $this->extra = new Collection();
        $this->flow = $this->container->make('flow');
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
     * @return array
     */
    public function data()
    {
        return $this->data->toArray();
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
     * Execute Handler.
     *
     * @throws \Exception
     */
    abstract protected function execute();

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
     * @param $permission
     *
     * @return bool
     */
    protected function permission($permission)
    {
        return $this->container->make(PermissionManager::class)->check($permission);
    }

    /**
     * Make data to response with errors or messages.
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function toResponse()
    {
        $response = new ApiResponse();
        try {
            $this->execute();
            if ($this->code !== 200) {
                $messages = $this->errors();
            } else {
                $messages = $this->messages();
            }
            $response = $response->withParams([
                'code'    => $this->code(),
                'data'    => $this->data(),
                'message' => $messages,
            ]);
            if ($this->extra->count()) {
                $response = $response->withParams($this->extra->toArray());
            }

            return $response;
        } catch (Exception $exception) {
            return $this->handleExceptions($response, $exception);
        }
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
     * @param $data
     *
     * @return $this
     */
    protected function withData($data)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }
        foreach ((array)$data as $key=>$value) {
            if (is_numeric($key)) {
                $this->data->push($value);
            } else {
                $this->data->put($key, $value);
            }
        }

        return $this;
    }

    /**
     * @param array|string $errors
     *
     * @return $this
     */
    protected function withError($errors)
    {
        foreach ((array)$errors as $error) {
            $this->errors->push($this->translator->trans($error));
        }

        return $this;
    }

    /**
     * @param $extras
     *
     * @return $this
     */
    public function withExtra($extras)
    {
        foreach ((array)$extras as $key=>$extra) {
            if (!is_numeric($key)) {
                $this->extra->put($key, $extra);
            }
        }

        return $this;
    }

    /**
     * @param array|string $messages
     *
     * @return $this
     */
    protected function withMessage($messages)
    {
        foreach ((array)$messages as $message) {
            $this->messages->push($this->translator->trans($message));
        }

        return $this;
    }
}
