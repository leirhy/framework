<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-18 17:50
 */
namespace Notadd\Foundation\GraphQL\Types;

use GraphQL\Type\Definition\InputObjectType;

/**
 * Class InputType.
 */
class InputType extends Type
{
    public function toType()
    {
        return new InputObjectType($this->toArray());
    }
}
