<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-24 15:24
 */
namespace Notadd\Foundation\Setting\GraphQL\Mutations;

use Notadd\Foundation\GraphQL\Abstracts\Mutation;

/**
 * Class SettingMutation.
 */
class SettingMutation extends Mutation
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'setting.setting';
    }

    /**
     * @return mixed
     */
    public function resolve()
    {
        // TODO: Implement resolve() method.
    }
}
