<?php


return [
    /**
     * CAS 服务地址
     */
    'server' => env('CAS_SERVER', 'https://account.zbanx.com'),

    /**
     * App id & App Secret
     */
    'app_id' => env('CAS_APP_ID'),
    'app_secret' => env('CAS_APP_SECRET'),


    /**
     * 授权相关
     */
    'auth' => [
        'guard' => 'banker',
        'model' => App\Models\User::class,
    ],

    /**
     * 请求相关
     */
    'request' => [
        'log' => env('CAS_REQUEST_LOG', false), // 是否记录日志
        'log_channel' => null,                              // 日志记录通道
    ],

    // TOKEN 有效时间
    'ttl' => env('CAS_TTL', 7200),

    'cache' => [
        'prefix' => 'cas'
    ]

];