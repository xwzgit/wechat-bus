<?php
return [
    //开放平台
    'open' => [
        'app_id' => '开发平台appId',
        'app_secret' => '开发平台appSecret',
        'token' => '开发平台token',
        'encoding_key' => '开发平台消息加解密key',
        'auth_redirect' => '开发平台授权毁掉地址',
        'auth_page' => '开发平台授权发起页面地址',
    ],

    //公众号信息
    'weChat' => [
        'app_id' => '公众号APPId',
        'app_secret' => '公众号Secret',
        'encoding_key' => '公众号加解密key',
        'token' => '公众号token',
        'redirect_uri' => '公众号网页授权回调地址',
        'response_type' => 'code',
        'scope' => 'snsapi_base',//公众号授权类型：'snsapi_base','snsapi_userinfo'
        'use_proxy' => 1,
    ],

    'log' => [
        'file' => storage_path('/logs/open.log'),//日志地址
        'level' => env('APP_LOG_LEVEL'),//日志等级
        'type' => env('APP_LOG','daily'),//日志记录频次
        'max_file' => 30,
    ],
    //是否使用已授权第三方平公众号：如果公众号授权给了平台，那么如果用户不想通过自己的公众号发起网页授权，可以使用平台默认公众号发起
    'third_authorized' => true,
    'use_robot' => false, //是否使用机器人自动回复

    'juhe_bind' => env('PUSHER_JUHE_BIND_URL'), //聚合账户微信绑定地址
];
