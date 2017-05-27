<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-23 15:11
 */
namespace Notadd\Foundation\Passport\Abstracts;

use Exception;
use Notadd\Foundation\Passport\Responses\ApiResponse;

/**
 * Class SetHandler.
 */
abstract class SetHandler extends DataHandler
{
    /**
     * Make execute result to response with errors or messages.
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function toResponse()
    {
        $response = new ApiResponse();
        try {
            $result = $this->execute();
            if ($result) {
                $messages = $this->messages();
            } else {
                $messages = $this->errors();
            }

            return $response->withParams([
                'code' => $this->code(),
                'data' => $this->data(),
                'message' => $messages,
            ]);
        } catch (Exception $exception) {
            return $this->handleExceptions($response, $exception);
        }
    }
}
