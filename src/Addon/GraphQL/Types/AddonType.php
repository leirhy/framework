<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-09-26 14:58
 */
namespace Notadd\Foundation\Addon\GraphQL\Types;

use Notadd\Foundation\GraphQL\Types\Type;

/**
 * Class AddonType.
 */
class AddonType extends Type
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
        return 'addon';
    }
}
