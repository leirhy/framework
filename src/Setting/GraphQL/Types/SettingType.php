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
use Notadd\Foundation\GraphQL\Types\Type;

/**
 * Class SettingType.
 */
class SettingType extends Type
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'key'   => [
                'type'        => TypeDefinition::nonNull(TypeDefinition::string()),
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
        return 'setting.setting';
    }
}
