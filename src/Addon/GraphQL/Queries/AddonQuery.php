<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-19 18:04
 */
namespace Notadd\Foundation\Addon\GraphQL\Queries;

use GraphQL\Type\Definition\Type;
use Notadd\Foundation\GraphQL\Abstracts\Query;

/**
 * Class ConfigurationQuery.
 */
class AddonQuery extends Query
{
    /**
     * @param $root
     * @param $args
     *
     * @return array
     */
    public function resolve($root, $args)
    {
        return $this->addon->repository()->toArray();
    }

    public function type()
    {
        return Type::listOf($this->graphql->type('addon'));
    }
}
