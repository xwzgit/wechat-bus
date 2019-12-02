<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus;


use WeChatBus\Open\Open;

class OpenApiServer
{
    protected static $open;
    protected static $config = [];

    /**
     *
     *
     * @return mixed
     * @throws \Exception
     */
    protected static function newOpen()
    {
        if (!(static::$open instanceof Open)) {
            static::$open = new Open(static::$config);
        }
        return static::$open;
    }
    
    /**
     * 刷新第三方平台Access Token
     *
     * @param $config
     * @param $verifyTicket
     * @return mixed
     * @throws \Exception
     */
    public static function componentAccessToken($config,$verifyTicket)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams(['verifyTicket' => $verifyTicket]);
        return $open->componentAccessToken();
    }

    /**
     * 获取预授权码
     *
     * @param $config
     * @param $comAccToken
     * @return mixed
     * @throws \Exception
     */
    public static function preAuthCode($config,$comAccToken)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams(['componentAccessToken' => $comAccToken]);
        return $open->preAuthCode();
    }

    /**
     * 生成授权链接
     *
     * @param $config
     * @param $preAuthCode
     * @return mixed
     * @throws \Exception
     */
    public static function createAuthUrl($config,$preAuthCode)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams(['preAuthCode' => $preAuthCode]);
        $response = $open->createAuthUrl();
        if ($response['errcode'] == 0) {
            return $response['authUrl'];
        }

    }

    /**
     * 获取公众号授权信息
     *
     * @param $config
     * @param $comAccToken
     * @param $authCode
     * @return mixed
     * @throws \Exception
     */
    public static function authAccessToken($config,$comAccToken,$authCode)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams([
            'componentAccessToken' => $comAccToken,
            'authCode' => $authCode
        ]);
        return $open->authAccessToken();
    }

    /**
     * 刷新授权Access Token
     *
     * @param $config
     * @param $comAccToken
     * @param $authAppId
     * @param $refreshToken
     * @return bool
     * @throws \Exception
     */
    public static function refreshAuthAccessToken($config,$comAccToken,$authAppId, $refreshToken)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams([
            'componentAccessToken' => $comAccToken,
            'authAppId' => $authAppId,
            'refreshToken' => $refreshToken,
        ]);
        return $open->refreshAuthAccessToken();
    }

    /**
     * 获取授权方的帐号基本信息
     *
     * @param $config
     * @param $comAccToken
     * @param $authAppId
     * @return array|bool|mixed
     * @throws \Exception
     */
    public static function authorizeInfo($config,$comAccToken,$authAppId)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams([
            'componentAccessToken' => $comAccToken,
            'authAppId' => $authAppId,
        ]);
        return $open->authorizeInfo();
    }

    /**
     * 获取授权工作号列表
     *
     * @param $config
     * @param $comAccToken
     * @param int $count
     * @param int $offset
     * @return mixed
     * @throws \Exception
     */
    public static function authorizeList($config,$comAccToken,$count = 20 ,$offset = 0)
    {
        static::$config = $config;

        $open = static::newOpen();
        $open->setRequestParams([
            'componentAccessToken' => $comAccToken,
            'count' => $count,
            'offset' => $offset,
        ]);
        return $open->authorizeList();
    }


    /**
     * 获取第三方平台代公众号清理接口请求次数
     *
     * @param $config
     * @param $appId
     * @param $accessToken
     * @return mixed
     * @throws \Exception
     */
    public static function clearWeChatQuota($config,$appId, $accessToken)
    {
        static::$config = $config;

        $open = static::newOpen();
        $params = [
            'appId' => $appId,
            'accessToken' => $accessToken,
        ];
        $open->setRequestParams($params);
        return $open->clearWeChatQuota();
    }

    /**
     * 获取第三方平台清零接口调用次数
     *
     * @param $config
     * @param $componentAccessToken
     * @return mixed
     * @throws \Exception
     */
    public static function clearComponentQuota($config,$componentAccessToken)
    {
        static::$config = $config;
        $open = static::newOpen();
        $params = [
            'componentAccessToken' => $componentAccessToken,
        ];
        $open->setRequestParams($params);
        return $open->createWebAuthorizeUrl();
    }

}