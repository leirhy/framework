<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 15:10
 */
namespace Notadd\Foundation\Passport\Abstracts;

use Exception;
use Notadd\Foundation\Passport\Responses\ApiResponse;

/**
 * Class DataHandler.
 */
abstract class DataHandler extends Handler
{
    /**
     * Data for handler.
     *
     * @return array
     * @throws \Exception
     */
    public function data()
    {
        throw new Exception('Data is not setted!');
    }

    /**
     * Make data to response with errors or messages.
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function toResponse()
    {
        $data = $this->data();
        if (empty($data)) {
            $messages = $this->errors();
        } else {
            $messages = $this->messages();
        }
        $response = new ApiResponse();

        return $response->withParams([
            'code'    => $this->code(),
            'data'    => $data,
            'message' => $messages,
        ]);
    }
}
