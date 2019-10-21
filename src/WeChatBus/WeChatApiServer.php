<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus;

use WeChatBus\WeChat\Develop\WeChatApi;

class WeChatApiServer
{
    protected static $weChatApi;

    /**
     * 获取菜单处理示例
     *
     * @param $model
     * @return mixed
     */
    protected static function getBusinessInstance($model)
    {
        $business = [
            'menu' => '',
        ];
        if(static::$config) {
            $config = static::$config;
        } else {
            $config = [];
        }

        return new $business[$model]($config);

    }
    /**
     *
     * @param $model
     * @return mixed
     */
    public static function newWeChatApi($model)
    {
        if (!(static::$weChatApi instanceof WeChatApi)) {
            static::$weChatApi = self::getBusinessInstance($model);
        }
        return static::$weChatApi;
    }

    /**
     * 获取公众号自定义才当
     *x
     * @param $accessToken
     * @param array $config
     * @return mixed
     */
    public static function getCustomMenus($action,$accessToken,$config = [])
    {
        static::$config = $config;

        $weChatApi = static::newWeChatApi($action);

        $params = [
            'accessToken' => $accessToken,
        ];

        $weChatApi->setRequestParams($params);
        return $weChatApi->getCustomMenus();
    }
}