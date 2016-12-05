<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-23 14:07
 */
namespace Notadd\Foundation\Routing\Abstracts;

/**
 * Class ApiController.
 */
abstract class ApiController extends Controller
{
    protected $client;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO: Method send Description
     *
     * @param $handler
     */
    public function send($handler)
    {
    }
}
