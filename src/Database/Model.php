<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-12-01 20:14
 */
namespace Notadd\Foundation\Database;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Notadd\Foundation\Database\Traits\Extendable;

/**
 * Class Model.
 */
class Model extends EloquentModel
{
    use Extendable;

    /**
     * @var \Illuminate\Contracts\Container\Container|\Notadd\Foundation\Application
     */
    protected $container;

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->container = Container::getInstance();
    }
}
