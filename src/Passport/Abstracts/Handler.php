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
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;

/**
 * Class Handler.
 */
abstract class Handler
{
    /**
     * @var \Illuminate\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

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
     * @param \Illuminate\Http\Request                                       $request
     * @param \Illuminate\Translation\Translator                             $translator
     */
    public function __construct(Container $container, Request $request, Translator $translator)
    {
        $this->container = $container;
        $this->request = $request;
        $this->translator = $translator;
    }

    /**
     * Http code.
     *
     * @return int
     * @throws \Exception
     */
    public function code()
    {
        throw new Exception('Code is not setted!');
    }

    /**
     * Errors for handler.
     *
     * @return array
     * @throws \Exception
     */
    public function errors()
    {
        throw new Exception('Error is not setted!');
    }

    /**
     * Messages for handler.
     *
     * @return array
     * @throws \Exception
     */
    public function messages()
    {
        throw new Exception('Message is not setted!');
    }
}
