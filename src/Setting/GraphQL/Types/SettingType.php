<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-24 15:38
 */
namespace Notadd\Foundation\Setting\GraphQL\Types;

use GraphQL\Type\Definition\Type as TypeDefinition;
use Notadd\Foundation\GraphQL\Abstracts\Type;

/**
 * Class SettingType.
 */
class SettingType extends \Notadd\Foundation\GraphQL\Abstracts\Type
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'key'   => [
                'type'        => TypeDefinition::string(),
                'description' => 'The key of the setting',
            ],
            'value' => [
                'type'        => TypeDefinition::string(),
                'description' => 'The value of the setting',
            ],
        ];
    }

    /**
     * @return string
     */
    public function name()
    {
        return 'Setting';
    }

    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public function type()
    {
        return TypeDefinition::string();
    }
}
