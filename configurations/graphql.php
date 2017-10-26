<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-10-26 14:03
 */
return [
    'schema'  => 'default',
    'schemas' => [
        'default' => [
            'mutation' => [
                'administration.navigation' => \Notadd\Foundation\Administration\GraphQL\Mutations\NavigationMutation::class,
                'cache.clear'               => \Notadd\Foundation\Cache\GraphQL\Mutations\ClearMutation::class,
                'extension.extension'       => \Notadd\Foundation\Extension\GraphQL\Mutations\ExtensionMutation::class,
                'module.module'             => \Notadd\Foundation\Module\GraphQL\Mutations\ModuleMutation::class,
                'setting.setting'           => \Notadd\Foundation\Setting\GraphQL\Mutations\SettingMutation::class,
            ],
            'query'    => [
                'administration.dashboard'   => \Notadd\Foundation\Administration\GraphQL\Queries\DashboardQuery::class,
                'administration.information' => \Notadd\Foundation\Administration\GraphQL\Queries\InformationQuery::class,
                'administration.navigation'  => \Notadd\Foundation\Administration\GraphQL\Queries\NavigationQuery::class,
                'extension.extension'        => \Notadd\Foundation\Extension\GraphQL\Queries\ExtensionQuery::class,
                'module.module'              => \Notadd\Foundation\Module\GraphQL\Queries\ModuleQuery::class,
                'setting.setting'            => \Notadd\Foundation\Setting\GraphQL\Queries\SettingQuery::class,
            ],
        ],
    ],
    'types'   => [
        \Notadd\Foundation\Administration\GraphQL\Types\DashboardType::class,
        \Notadd\Foundation\Administration\GraphQL\Types\InformationType::class,
        \Notadd\Foundation\Administration\GraphQL\Types\NavigationType::class,
        \Notadd\Foundation\Extension\GraphQL\Types\ExtensionType::class,
        \Notadd\Foundation\Module\GraphQL\Types\ModuleType::class,
        \Notadd\Foundation\Setting\GraphQL\Types\SettingType::class,
    ],
];