<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-12-01 20:14
 */
namespace Notadd\Foundation\Database;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Model.
 */
class Model extends EloquentModel
{
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
