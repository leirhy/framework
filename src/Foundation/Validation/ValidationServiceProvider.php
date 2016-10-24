<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-21 14:56
 */
namespace Notadd\Foundation\Validation;
use Illuminate\Validation\ValidationServiceProvider as IlluminateValidationServiceProvider;
/**
 * Class ValidationServiceProvider
 * @package Notadd\Foundation\Validation
 */
class ValidationServiceProvider extends IlluminateValidationServiceProvider {
    protected $defer = true;
}