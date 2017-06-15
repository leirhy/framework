<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-15 14:19
 */
namespace Notadd\Foundation\Database\Traits;

/**
 * Trait Extendable.
 */
trait Extendable
{
    /**
     * @var array
     */
    protected static $extendFillable = [];

    /**
     * @var array
     */
    protected static $extendRelation = [];

    /**
     * @param string $type
     *
     * @throws \Exception
     */
    public static function extend(string $type)
    {
        switch ($type) {
            case 'fillable':
                if (func_num_args() == 2) {
                    static::$extendFillable = array_merge((array)func_get_arg(1), static::$extendFillable);
                }
                break;
            case 'relation':
                if (($relation = func_get_arg(1))
                    && ($callback = func_get_arg(2))
                    && is_string($relation) && $callback instanceof \Closure
                ) {
                    static::$extendRelation[ $relation ] = $callback;
                }
                break;
            default:
                throw new \Exception('No support extend type!');
                break;
        }
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        if (static::$extendFillable) {
            return array_merge(static::$extendFillable, $this->fillable);
        }

        return $this->fillable;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (array_key_exists($method, static::$extendRelation)) {
            $callback = static::$extendRelation[ $method ];

            return $callback($this);
        }

        return parent::__call($method, $parameters);
    }
}
