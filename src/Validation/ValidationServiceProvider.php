<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-21 14:56
 */
namespace Notadd\Foundation\Validation;

use Illuminate\Validation\ValidationServiceProvider as IlluminateValidationServiceProvider;

/**
 * Class ValidationServiceProvider.
 */
class ValidationServiceProvider extends IlluminateValidationServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
}
