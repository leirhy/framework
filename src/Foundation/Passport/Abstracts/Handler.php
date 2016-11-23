<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 14:21
 */
namespace Notadd\Foundation\Passport\Abstracts;

/**
 * Class Handler.
 */
abstract class Handler
{
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
    public function data()
    {
        throw new \Exception('Data is not setted!');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function message()
    {
        throw new \Exception('Message is not setted!');
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'code' => $this->code(),
            'data' => $this->data(),
            'message' => $this->message(),
        ];
    }
}