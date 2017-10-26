<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-18 17:52
 */
namespace Notadd\Foundation\GraphQL\Abstracts;

use GraphQL\Type\Definition\Type;
use Illuminate\Container\Container;
use Notadd\Foundation\GraphQL\Errors\AuthorizationError;
use Notadd\Foundation\GraphQL\GraphQLManager;
use Notadd\Foundation\Routing\Traits\Helpers;

/**
 * Class Query.
 */
abstract class Query
{
    use Helpers {
        __get as HelperGet;
    }

    /**
     * @var array.
     */
    protected $attributes = [];

    /**
     * @var \Illuminate\Container\Container.
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\GraphQL\GraphQLManager.
     */
    protected $graphql;

    /**
     * Query constructor.
     *
     * @param \Illuminate\Container\Container           $container
     * @param \Notadd\Foundation\GraphQL\GraphQLManager $graphql
     */
    public function __construct(Container $container, GraphQLManager $graphql)
    {
        $this->container = $container;
        $this->graphql = $graphql;
    }

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
     * @param $root
     * @param $args
     *
     * @return mixed
     */
    abstract public function resolve($root, $args);

    /**
     * @return array
     */
    public function toArray()
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
        $resolver = [$this, 'resolve'];
        $authorize = [$this, 'authorize'];
        $resolver = function () use ($resolver, $authorize) {
            $args = func_get_args();
            if (call_user_func_array($authorize, $args) !== true) {
                throw new AuthorizationError('Unauthorized');
            }

            return call_user_func_array($resolver, $args);
        };
        if (isset($resolver)) {
            $attributes['resolve'] = $resolver;
        }

        return $attributes;
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
