<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-23 19:59
 */
namespace Notadd\Foundation\Module\GraphQL\Types;

use Notadd\Foundation\GraphQL\Abstracts\Type;

/**
 * Class ModuleType.
 */
class ModuleType extends Type
{
    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * @return string
     */
    public function name()
    {
        return 'ModuleModule';
    }
}
