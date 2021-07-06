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
     * 授权
     */
    'guard' => 'api',

    // TOKEN 有效时间
    'ttl' => env('CAS_TTL', 3600)

];