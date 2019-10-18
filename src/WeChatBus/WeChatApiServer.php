<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace ApiServer;

use Open\Auth\Open;
use WeChatBus\WeChat\Develop\WeChatApi;

class WeChatApiServer
{
    protected static $weChatApi;

    /**
     *
     * @param $config
     * @return mixed
     */
    public static function newWeChatApi()
    {
        if (!(static::$weChatApi instanceof WeChatApi)) {
            static::$weChatApi = new WeChatApi(static::$config);
        }
        return static::$weChatApi;
    }

    /**
     * 获取公众号自定义才当
     *
     * @param $accessToken
     * @param array $config
     * @return mixed
     */
    public static function getCustomMenus($accessToken,$config = [])
    {
        static::$config = $config;

        $weChatApi = static::newWeChatApi();

        $params = [
            'accessToken' => $accessToken,
        ];

        $weChatApi->setRequestParams($params);
        return $weChatApi->getCustomMenus();
    }
}