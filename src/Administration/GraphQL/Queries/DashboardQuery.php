<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-26 12:04
 */
namespace Notadd\Foundation\Administration\GraphQL\Queries;

use Notadd\Foundation\GraphQL\Abstracts\Query;

/**
 * Class DashboardQuery.
 */
class DashboardQuery extends Query
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'administration.dashboard';
    }

    /**
     * @return mixed
     */
    public function resolve()
    {
        // TODO: Implement resolve() method.
    }
}
