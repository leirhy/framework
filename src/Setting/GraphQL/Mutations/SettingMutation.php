<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-24 15:24
 */
namespace Notadd\Foundation\Setting\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Notadd\Foundation\GraphQL\Abstracts\Mutation;

/**
 * Class SettingMutation.
 */
class SettingMutation extends Mutation
{
    /**
     * @return array
     */
    public function args()
    {
        return [
            'key'   => [
                'name' => 'key',
                'type' => Type::string(),
            ],
            'value' => [
                'name' => 'key',
                'type' => Type::string(),
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function resolve()
    {
        // TODO: Implement resolve() method.
    }

    /**
     * @return \GraphQL\Type\Definition\ListOfType
     */
    public function type()
    {
        return Type::listOf($this->graphql->type('Setting'));
    }
}
