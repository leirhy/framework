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
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * Handler constructor.
     *
     * @param \Illuminate\Container\Container|\Notadd\Foundation\Application $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->translator = $this->container->make('translator');
    }
    /**
     * @return int
     * @throws \Exception
     */
    public function code()
    {
        throw new \Exception('Code is not setted!');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function errors()
    {
        throw new \Exception('Error is not setted!');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function messages()
    {
        throw new \Exception('Message is not setted!');
    }
}
