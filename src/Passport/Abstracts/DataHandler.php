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
     * @var bool
     */
    protected $hasFilter = false;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

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
     * Add filter to filters.
     *
     * @return $this
     */
    public function filter()
    {
        list($column, $operator, $value, $boolean) = func_get_args();
        empty($operator) && $operator = null;
        empty($value) && $value = null;
        empty($boolean) && $boolean = null;
        if($this->hasFilter) {
            $this->model = $this->model->where($column, $operator, $value, $boolean);
        } else {
            $this->model = $this->model->newQuery()->where($column, $operator, $value, $boolean);
            $this->hasFilter = true;
        }

        return $this;
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
