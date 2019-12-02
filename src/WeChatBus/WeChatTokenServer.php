<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus;

use WeChatBus\WeChat\Token\BasicToken;

class WeChatTokenServer
{
    protected static $token;
    protected static $config = [];

    /**
     *
     *
     * @return mixed
     * @throws \Exception
     */
    protected static function newToken()
    {
        if (!(static::$token instanceof BasicToken)) {
            static::$token = new BasicToken(static::$config);
        }
        return static::$token;
    }

    /**
     * 获取去公众号的基础Access Token
     *
     * @param $config
     * @return mixed
     * @throws \Exception
     */
    public static function getBasicAccessToken($config)
    {
        static::$config = $config;
        $token = static::newToken();

        return $token->getBasicAccessToken();
    }

    /**
     * 获取jsApiTicket
     *
     * @param string $accessToken 公众号开发基础token
     * @return mixed
     * @throws \Exception
     */
    public static function getJsApiTicket($accessToken)
    {
        $token = static::newToken();
        $params = [
            'accessToken' => $accessToken,
        ];

        $token->setRequestParams($params);
        return $token->getJsTicketToken();
    }

    /**
     * 获取分享配置
     *
     *
     * @param $jsApiTicket
     * @param $signUrl
     * @return mixed
     * @throws \Exception
     */
    public static function getShareSetting($jsApiTicket, $signUrl)
    {
        $token = static::newToken();

        $params = [
            'jsApiTicket' => $jsApiTicket,
            'signUrl' => $signUrl,
        ];
        $token->setRequestParams($params);
        return $token->getShareSetting();
    }

    /**
     * 获取关注公众号用户的信息，可作为是否关注判断
     *
     *
     * @param $accessToken
     * @param $openId
     * @return mixed
     * @throws \Exception
     */
    public static function getWeChatAttention($accessToken, $openId)
    {
        $token = static::newToken();

        $params = [
            'accessToken' => $accessToken,
            'openId' => $openId,
        ];
        $token->setRequestParams($params);
        return $token->getWeChatAttentionInfo();
    }


}