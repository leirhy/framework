<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-23 19:57
 */
namespace Notadd\Foundation\Administration\GraphQL\Types;

use Notadd\Foundation\GraphQL\Types\Type;

/**
 * Class MenuType.
 */
class NavigationType extends Type
{
    /**
     * @return array
     */
    public function fields()
    {
        // TODO: Implement fields() method.
    }

    /**
     * @return string
     */
    public function name()
    {
        return 'administration.navigation';
    }
}
