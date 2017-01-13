<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-13 12:17
 */

return [
    'default'     => env('BROADCAST_DRIVER', 'null'),
    'connections' => [
        'pusher' => [
            'driver'  => 'pusher',
            'key'     => env('PUSHER_KEY'),
            'secret'  => env('PUSHER_SECRET'),
            'app_id'  => env('PUSHER_APP_ID'),
            'options' => [
            ],
        ],
        'redis'  => [
            'driver'     => 'redis',
            'connection' => 'default',
        ],
        'log'    => [
            'driver' => 'log',
        ],
        'null'   => [
            'driver' => 'null',
        ],
    ],
];
