<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-11-03 17:28
 */
namespace Notadd\Foundation\Module\GraphQL\Mutations;

use Notadd\Foundation\GraphQL\Abstracts\Mutation;

/**
 * Class UninstallMutation.
 */
class UninstallMutation extends Mutation
{
    /**
     * @return array
     */
    public function args(): array
    {
        return [];
    }

    /**
     * @param $root
     * @param $args
     *
     * @return mixed
     */
    public function resolve($root, $args)
    {
        // TODO: Implement resolve() method.
    }
}
