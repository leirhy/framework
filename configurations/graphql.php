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
                'navigations' => \Notadd\Foundation\Administration\GraphQL\Mutations\NavigationMutation::class,
                'clearCache'  => \Notadd\Foundation\Cache\GraphQL\Mutations\ClearMutation::class,
                'extensions'  => \Notadd\Foundation\Extension\GraphQL\Mutations\ExtensionMutation::class,
                'modules'     => \Notadd\Foundation\Module\GraphQL\Mutations\ModuleMutation::class,
                'settings'    => \Notadd\Foundation\Setting\GraphQL\Mutations\SettingMutation::class,
            ],
            'query'    => [
                'addons'       => \Notadd\Foundation\Addon\GraphQL\Queries\AddonQuery::class,
                'dashboards'   => \Notadd\Foundation\Administration\GraphQL\Queries\DashboardQuery::class,
                'informations' => \Notadd\Foundation\Administration\GraphQL\Queries\InformationQuery::class,
                'navigations'  => \Notadd\Foundation\Administration\GraphQL\Queries\NavigationQuery::class,
                'extensions'   => \Notadd\Foundation\Extension\GraphQL\Queries\ExtensionQuery::class,
                'modules'      => \Notadd\Foundation\Module\GraphQL\Queries\ModuleQuery::class,
                'settings'     => \Notadd\Foundation\Setting\GraphQL\Queries\SettingQuery::class,
            ],
        ],
    ],
    'types'   => [
        \Notadd\Foundation\Addon\GraphQL\Types\AddonType::class,
        \Notadd\Foundation\Administration\GraphQL\Types\DashboardType::class,
        \Notadd\Foundation\Administration\GraphQL\Types\InformationType::class,
        \Notadd\Foundation\Administration\GraphQL\Types\NavigationType::class,
        \Notadd\Foundation\Extension\GraphQL\Types\ExtensionType::class,
        \Notadd\Foundation\Module\GraphQL\Types\ModuleType::class,
        \Notadd\Foundation\Setting\GraphQL\Types\SettingType::class,
    ],
];