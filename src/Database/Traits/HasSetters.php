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
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if (isset($this->setters[$key])) {
            $rule = $this->setters[$key][0];
            $default = $this->setters[$key][1];
            if ($rule instanceof \Closure && $rule($value)) {
                parent::setAttribute($key, $default);
            } elseif (is_string($rule)) {
                switch ($rule) {
                    case 'null':
                        is_null($value) && parent::setAttribute($key, $default);
                        break;
                    default:
                        parent::setAttribute($key, $value);
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
