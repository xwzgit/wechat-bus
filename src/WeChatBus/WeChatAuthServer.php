<?php
/**
 * 公众号发起网页授权
 *
 */

namespace WeChatBus;


use WeChatBus\WeChat\Authorize\WeChatAuth;

class WeChatAuthServer
{
    protected static $authorize;
    protected static $config = [];


    /**
     *
     *
     * @param $config
     * @return mixed
     * @throws \Exception
     */
    protected static function newAuthorize()
    {
        if (!(static::$authorize instanceof WeChatAuth)) {
            static::$authorize = new WeChatAuth(static::$config);
        }
        return static::$authorize;
    }

    /**
     * 获取授权码
     *
     * @param @config
     * @return mixed
     * @throws \Exception
     */
    public static function getAuthCodeUrl($config)
    {
        static::$config = $config;
        $authorize = static::newAuthorize();
        return $authorize->getAuthCodeUrl();
    }

    /**
     * 通过$code 获取access token和OpenId
     *
     * @param $code
     * @param $config
     * @param $appId
     * @param $componentAccessToken
     * @return mixed
     * @throws \Exception
     */
    public static function getAccessToken($config,$code,$appId,$componentAccessToken = '')
    {
        static::$config = $config;

        $authorize = static::newAuthorize();

        $params = [
            'appId' => $appId,
            'code' => $code,
        ];

        if($config['third_authorized']) {
            $params['componentAccessToken'] = $componentAccessToken;
        }

        $authorize->setRequestParams($params);
        return $authorize->getAccessToken();
    }

    /**
     * 刷新网页授权Access Token
     *
     *
     * @param $config
     * @param $refreshToken
     * @param $appId
     * @param $componentAccessToken
     * @return mixed
     * @throws \Exception
     */
    public static function refreshAccessToken($config,$refreshToken,$appId,$componentAccessToken = '')
    {
        static::$config = $config;

        $authorize = static::newAuthorize();

        $params = [
            'appId' => $appId,
            'refreshToken' => $refreshToken
        ];

        //第三方平台刷新
        if($config['third_authorized']) {
            $params['componentAccessToken'] = $componentAccessToken;
        }

        $authorize->setRequestParams($params);

        return $authorize->refreshAccessToken();
    }

    /**
     * 根据用户openId 和access token 获取用户信息
     *
     * @param $openId
     * @param $appId
     * @param $config
     * @param $accessToken
     * @return mixed
     * @throws \Exception
     */
    public static function getUserInfo($config,$appId,$openId,$accessToken)
    {
        static::$config = $config;

        $authorize = static::newAuthorize();
        $params = [
            'appId' => $appId,
            'accessToken' => $accessToken,
            'openId' => $openId,
        ];

        $authorize->setRequestParams($params);
        return $authorize->getUserInfo();
    }

    /**
     * 根据用户openId 和access token 获取用户信息
     *
     * @param $openId
     * @param $appId
     * @param $config
     * @param $accessToken
     * @return mixed
     * @throws \Exception
     */
    public static function getSubscribeUserInfo($config,$appId,$openId,$accessToken)
    {
        static::$config = $config;

        $authorize = static::newAuthorize();
        $params = [
            'appId' => $appId,
            'accessToken' => $accessToken,
            'openId' => $openId,
        ];

        $authorize->setRequestParams($params);
        return $authorize->getSubscribeUserInfo();
    }

}