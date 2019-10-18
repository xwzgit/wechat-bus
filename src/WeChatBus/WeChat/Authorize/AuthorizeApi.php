<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus\WeChat\Authorize;


use WeChatBus\Support\Config\Config;
use WeChatBus\Support\Request\ApiRequest;
use WeChatBus\Support\Traits\BasicProcess;

class AuthorizeApi
{
    use BasicProcess;

    protected $config;
    protected $params;

    //获取授权码链接
    protected $authCodeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize';

    //获取Access Token
    protected $webAccessToken = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    //刷新Access Token
    protected $refreshAccessToken = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';

    //获取微信用户信息
    protected $userInfo = "https://api.weixin.qq.com/sns/userinfo";

    //通过code获取访问公众号用户信息的access_code
    protected $proxyWebAccessToken = 'https://api.weixin.qq.com/sns/oauth2/component/access_token';
    protected $proxyWebAccessTokenRefresh = 'https://api.weixin.qq.com/sns/oauth2/component/refresh_token';

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * 请求参数配置
     *
     * @param $params
     */
    public function setRequestParams($params)
    {
        $this->params = $params;
    }

    /**
     * 获取授权地址
     *
     * @return array
     * @throws \Exception
     */
    public function getAuthCodeUrl()
    {
        $params = [
            'appid' => $this->getConfigItem('weChat.app_id'),
            'redirect_uri' => $this->getConfigItem('weChat.redirect_uri'),
            'response_type' => $this->getConfigItem('weChat.response_type'),
            'scope' => $this->getConfigItem('weChat.scope'),
            'state' => 'STATE',
            'useProxy' => intval($this->getConfigItem('weChat.useProxy')),
        ];

        if ($this->config->get('third_authorized')) {
            unset($params['useProxy']);
            $params['component_appid'] = $this->getConfigItem('open.app_id') . "#wechat_redirect";
        } else {
            if ($params['useProxy'] == 1) {
                $authUrl = 'https://www.juhe.cn/weixin/proxy/auth?';
            } else {
                $params['state'] .= "#wechat_redirect";
                $authUrl = $this->authCodeUrl . '?';
            }
            unset($params['useProxy']);
        }

        $bizString = ApiRequest::convertUrlParams($params);
        //这里对授权回调进行了代理处理，因为一个公众号只能添加一个回调域名，所以做一个代理
        return [
            "errcode" => 0,
            "authUrl" => $authUrl . $bizString
        ];
    }

    /**
     * 获取用户的access token 和OpenId
     */
    public function getAccessToken()
    {
        $params = [
            'appid' => $this->getRequestParams('getAccessToken', 'appId'),
            'code' => $this->getRequestParams('getAccessToken', 'code'),
            'grant_type' => 'authorization_code'
        ];

        //授权第三方公众号
        if ($this->getConfigItem('third_authorized')) {
            $params['component_appid'] = $this->getConfigItem('open.app_id');
            $params['component_access_token'] = $this->getRequestParams('getAccessToken',
                'componentAccessToken');
            $accessTokenUrl = $this->proxyWebAccessToken;
        } else {
            $params['secret'] = $this->getConfigItem('weChat.app_secret');
            $accessTokenUrl = $this->webAccessToken;

        }
        return ApiRequest::getRequest('getAccessToken', $accessTokenUrl, $params);
    }

    /**
     * 刷新网页授权Access Token
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function refreshAccessToken()
    {
        $params = [
            'appid' => $this->getRequestParams('getUserInfo', 'appId'),
            'refresh_token' => $this->getRequestParams('getUserInfo', 'refreshToken'),
            'grant_type' => 'refresh_token'
        ];

        //授权第三方公众号
        if ($this->getConfigItem('third_authorized')) {

            $params['component_appid'] = $this->getConfigItem('open.app_id');
            $params['component_access_token'] = $this->getRequestParams('getAccessToken',
                'componentAccessToken');

            $refreshAccessTokenUrl = $this->proxyWebAccessTokenRefresh;
        } else {
            $params['secret'] = $this->getConfigItem('weChat.secret');
            $refreshAccessTokenUrl = $this->refreshAccessToken;

        }
        return ApiRequest::getRequest('refreshAccessToken', $refreshAccessTokenUrl, $params);
    }

    /**
     * 获取用户信息
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function getUserInfo()
    {
        $params = [
            'appid' => $this->getRequestParams('getUserInfo', 'appId'),
            'openid' => $this->getRequestParams('getUserInfo', 'openId'),
            'access_token' => $this->getRequestParams('getUserInfo', 'accessToken'),
            'lang' => 'zh_CN',
        ];

        return ApiRequest::getRequest('getUserInfo', $this->userInfo, $params);
    }

}