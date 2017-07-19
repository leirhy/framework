<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-07-18 17:43
 */
namespace Notadd\Foundation\Database\Traits;

/**
 * Trait HasSetters.
 */
trait HasSetters
{
    /**
     * @var array
     */
    protected $setters = [];

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if (isset($this->setters[$key])) {
            if (is_string($attributes = $this->setters[$key])) {
                list($rule, $default) = explode('|', $attributes);
            } else {
                $rule = $attributes[0];
                $default = $attributes[1];
            }
            if ($rule instanceof \Closure && $rule($value)) {
                parent::setAttribute($key, $default);
            } else if (is_string($rule)) {
                switch ($rule) {
                    case 'null':
                        if (is_null($value)) {
                            parent::setAttribute($key, $default);
                        } else {
                            parent::setAttribute($key, $value);
                        }
                        break;
                    default:
                        parent::setAttribute($key, $value);
                        break;
                }
            } else {
                parent::setAttribute($key, $value);
            }
        } else {
            parent::setAttribute($key, $value);
        }

        return $this;
    }
}
