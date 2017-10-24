<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-24 14:35
 */
namespace Notadd\Foundation\Setting\GraphQL\Queries;

use Notadd\Foundation\GraphQL\Abstracts\Query;

/**
 * Class SettingQuery.
 */
class SettingQuery extends Query
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'settings';
    }

    /**
     * @return mixed
     */
    public function resolve()
    {

    }
}
