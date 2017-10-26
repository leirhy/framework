<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-26 12:05
 */
namespace Notadd\Foundation\Administration\GraphQL\Queries;

use Notadd\Foundation\GraphQL\Abstracts\Query;

/**
 * Class InformationQuery.
 */
class InformationQuery extends Query
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'administration.information';
    }

    /**
     * @return mixed
     */
    public function resolve()
    {
        // TODO: Implement resolve() method.
    }
}
