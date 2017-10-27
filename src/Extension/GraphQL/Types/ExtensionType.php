<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-23 19:58
 */
namespace Notadd\Foundation\Extension\GraphQL\Types;

use Notadd\Foundation\GraphQL\Abstracts\Type;

/**
 * Class ExtensionType.
 */
class ExtensionType extends \Notadd\Foundation\GraphQL\Abstracts\Type
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
        return 'ExtensionExtension';
    }
}
