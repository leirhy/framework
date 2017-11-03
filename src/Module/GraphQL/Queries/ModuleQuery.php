<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-19 18:04
 */
namespace Notadd\Foundation\Module\GraphQL\Queries;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\Type;
use Notadd\Foundation\GraphQL\Abstracts\Query;
use Notadd\Foundation\Module\Module;

/**
 * Class ConfigurationQuery.
 */
class ModuleQuery extends Query
{
    /**
     * @return array
     */
    public function args()
    {
        return [
            'enabled'   => [
                'defaultValue' => null,
                'name' => 'enabled',
                'type' => Type::boolean(),
            ],
            'installed' => [
                'defaultValue' => null,
                'name' => 'installed',
                'type' => Type::boolean(),
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
        if ($args['enabled'] === true) {
            $collection = $this->module->enabled();
        } elseif ($args['installed'] === true) {
            $collection = $this->module->installed();
        } elseif ($args['installed'] === false) {
            $collection = $this->module->notInstalled();
        } else {
            $collection = $this->module->repository();
        }

        return $collection->map(function (Module $module) {
            $authors = (array)$module->get('author');
            $string = $authors[0] ?? '';
            $string .= ' <';
            $string .= $authors[1] ?? '';
            $string .= '>';
            $module->offsetSet('author', $string);

            return $module;
        })->toArray();
    }

    /**
     * @return \GraphQL\Type\Definition\ListOfType
     */
    public function type(): ListOfType
    {
        return Type::listOf($this->graphql->type('module'));
    }
}
