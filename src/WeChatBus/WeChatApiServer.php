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
    protected static $config;

    /**
     * 获取菜单处理示例
     *
     * @param $model
     * @return mixed
     */
    protected static function newWeChatApi($model)
    {
        $business = [
            'menus' => 'WeChatBus\WeChat\Develop\ApiModels\Menus',
            'msgTpl' => 'WeChatBus\WeChat\Develop\ApiModels\TemplateMessage',
        ];
        if (static::$config) {
            $config = static::$config;
        } else {
            $config = [];
        }
        if (!(static::$weChatApi instanceof $business[$model])) {
            static::$weChatApi = new $business[$model]($config);
        }
        return static::$weChatApi;
    }

    /**
     * 菜单类操作
     *
     *
     * @param string $action
     * [
     * getCustomMenus,
     * createMenus,
     * getMenus,
     * deleteMenus,
     * createConditionalMenus,
     * tryConditionalMenus,
     * deleteConditionalMenus,
     * ]
     * @param $accessToken
     * @param $buttons
     * @param array $config
     * @return mixed
     */
    public static function menusChannel($action, $accessToken, $buttons = [],$config = [])
    {
        static::$config = $config;

        $weChatApi = static::newWeChatApi('menus');

        $params = [
            'accessToken' => $accessToken,
        ];
        if($buttons) {
            $params['buttons'] = $buttons;

        }

        $weChatApi->setRequestParams($params);
        return $weChatApi->{$action}();
    }

    /**
     * 消息模板处理
     *
     * @param String $action
     * [
     * getTemplateList,
     * removeTemplate,
     * sendTemplateMessage
     * ]
     *
     * @param $accessToken
     * @param $post
     * @param array $config
     * @return mixed
     */
    public static function processMsgTpl($action, $accessToken, $post = [], $config = [])
    {
        static::$config = $config;

        $weChatApi = static::newWeChatApi('msgTpl');

        $params = [
            'accessToken' => $accessToken,
            'post' => $post,
        ];

        $weChatApi->setRequestParams($params);
        return $weChatApi->{$action}();
    }
}