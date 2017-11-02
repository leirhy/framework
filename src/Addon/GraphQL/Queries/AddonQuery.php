<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-19 18:04
 */
namespace Notadd\Foundation\Addon\GraphQL\Queries;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\Type;
use Notadd\Foundation\GraphQL\Abstracts\Query;

/**
 * Class ConfigurationQuery.
 */
class AddonQuery extends Query
{
    /**
     * @return array
     */
    public function args()
    {
        return [
            'enabled' => [
                'name' => 'enabled',
                'type' => Type::getNullableType(Type::boolean()),
            ],
            'installed' => [
                'name' => 'installed',
                'type' => Type::getNullableType(Type::boolean()),
            ],
        ];
    }

    /**
     * @param $root
     * @param $args
     *
     * @return array
     */
    public function resolve($root, $args)
    {
        if (isset($args['enabled']) && $args['enabled'] === true) {
            return $this->addon->enabled()->toArray();
        } elseif (isset($args['installed']) && $args['installed'] === true) {
            return $this->addon->installed()->toArray();
        } elseif (isset($args['installed']) && $args['installed'] === false) {
            return $this->addon->notInstalled()->toArray();
        }

        return $this->addon->repository()->toArray();
    }

    /**
     * @return \GraphQL\Type\Definition\ListOfType
     */
    public function type(): ListOfType
    {
        return Type::listOf($this->graphql->type('addon'));
    }
}
