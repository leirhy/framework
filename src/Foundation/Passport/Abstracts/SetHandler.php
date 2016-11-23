<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 15:11
 */
namespace Notadd\Foundation\Passport\Abstracts;

use Illuminate\Http\Request;
use Notadd\Foundation\Passport\Responses\ApiResponse;

/**
 * Class SetHandler.
 */
abstract class SetHandler extends DataHandler
{
    /**
     * @return array
     */
    public function data()
    {
        return [];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function execute(Request $request)
    {
        return true;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     */
    public function toResponse(Request $request)
    {
        $result = $this->execute($request);
        if ($result) {
            $messages = $this->messages();
        } else {
            $messages = $this->errors();
        }
        $response = new ApiResponse();
        return $response->withParams([
            'code' => $this->code(),
            'data' => $this->data(),
            'message' => $messages,
        ]);
    }
}
