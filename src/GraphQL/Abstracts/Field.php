<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-18 17:49
 */
namespace Notadd\Foundation\GraphQL\Abstracts;

use Illuminate\Support\Fluent;
use Notadd\Foundation\GraphQL\Errors\AuthorizationError;

/**
 * Class Field.
 */
abstract class Field extends Fluent
{
    /**
     * @param $root
     * @param $args
     *
     * @return bool
     */
    public function authorize($root, $args)
    {
        return true;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * @return null
     */
    public function type()
    {
        return null;
    }

    /**
     * @return array
     */
    public function args()
    {
        return [];
    }

    /**
     * @return \Closure|null
     */
    protected function getResolver()
    {
        if (!method_exists($this, 'resolve')) {
            return null;
        }
        $resolver = [$this, 'resolve'];
        $authorize = [$this, 'authorize'];

        return function () use ($resolver, $authorize) {
            $args = func_get_args();
            // Authorize
            if (call_user_func_array($authorize, $args) !== true) {
                throw new AuthorizationError('Unauthorized');
            }

            return call_user_func_array($resolver, $args);
        };
    }

    /**
     * Get the attributes from the container.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = $this->attributes();
        $args = $this->args();
        $attributes = array_merge($this->attributes, [
            'args' => $args,
        ], $attributes);
        $type = $this->type();
        if (isset($type)) {
            $attributes['type'] = $type;
        }
        $resolver = $this->getResolver();
        if (isset($resolver)) {
            $attributes['resolve'] = $resolver;
        }

        return $attributes;
    }

    /**
     * Convert the Fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        $attributes = $this->getAttributes();

        return isset($attributes[$key]) ? $attributes[$key] : null;
    }

    /**
     * Dynamically check if an attribute is set.
     *
     * @param $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        $attributes = $this->getAttributes();

        return isset($attributes[$key]);
    }
}
