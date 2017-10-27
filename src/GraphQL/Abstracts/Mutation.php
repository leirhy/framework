<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-18 17:51
 */
namespace Notadd\Foundation\GraphQL\Abstracts;

use GraphQL\Type\Definition\Type;
use Notadd\Foundation\GraphQL\Errors\AuthorizationError;
use Notadd\Foundation\GraphQL\Traits\ShouldValidate;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class Mutation.
 */
abstract class Mutation
{
    use Helpers {

    }
    use ShouldValidate;

    /**
     * @var array.
     */
    protected $attributes = [];

    /**
     * @return array
     */
    public function args()
    {
        return [];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [];
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
     * @return mixed
     */
    abstract public function resolve();

    /**
     * @return \Closure|null
     */
    protected function getResolver()
    {
        $resolver = [$this, 'resolve'];
        $authorize = [$this, 'authorize'];
        return function () use ($resolver, $authorize) {
            $args = func_get_args();
            if (call_user_func_array($authorize, $args) !== true) {
                throw new AuthorizationError('Unauthorized');
            }
            return call_user_func_array($resolver, $args);
        };
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
     * @return \GraphQL\Type\Definition\ListOfType
     */
    public function type()
    {
        return Type::listOf(Type::string());
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
        $attributes = $this->toArray();

        return isset($attributes[$key]) ? $attributes[$key] : $this->HelperGet($key);
    }
}
