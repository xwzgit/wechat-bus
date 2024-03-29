<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus\Open;



use WeChatBus\Support\Config\Config;
use WeChatBus\Support\Request\ApiRequest;
use WeChatBus\Support\Traits\BasicProcess;

class OpenApi
{
    use BasicProcess;

    protected $config;
    protected $params;
    protected $authUrl = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';
    protected $comAccTk = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
    protected $repAccTk = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode';
    protected $authAccTk = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth';
    protected $refAuthAccTk = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token';
    protected $authorList = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info';

    protected $authInfo = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_list';

    //代公众号调用接口调用次数清零 API 的权限。
    protected $clearQuota = 'https://api.weixin.qq.com/cgi-bin/clear_quota';

    //第三方平台对其所有 API 调用次数清零（只与第三方平台相关，与公众号无关，接口如 api_component_token）
    protected $componentClearQuota = 'https://api.weixin.qq.com/cgi-bin/component/clear_quota';



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
     * 刷新第三方平台Access Token
     *
     *
     * @param $ticket
     * @return array|bool|mixed
     */
    public function componentAccessToken()
    {

        $ticket = $this->getRequestParams('componentAccessToken', 'verifyTicket');
        $params = $this->globalParams(['component_appid' => '', 'component_appsecret' => '']);
        $params['component_verify_ticket'] = $ticket;

        return ApiRequest::postRequest('componentAccessToken', $this->comAccTk, $params);
    }


    /**
     * 获取预授权码
     *
     * @return array|bool|mixed
     */
    public function preAuthCode()
    {
        $params = $this->globalParams(['component_appid' => '']);
        $comAccTk = $this->getRequestParams('componentAccessToken', 'componentAccessToken');

        $url = $this->repAccTk . '?component_access_token=' . $comAccTk;
        return ApiRequest::postRequest('preAuthCode', $url, $params);
    }

    /**
     * 生成授权链接
     *
     * @param $preAuthCode
     * @param $redirectUrl
     * @return string
     */
    public function createAuthUrl()
    {
        $params = $this->globalParams(['component_appid' => '']);

        $params['pre_auth_code'] = $this->getRequestParams('createAuthUrl', 'preAuthCode');
        $params['auth_type'] = 1;
        $params['redirect_uri'] = $this->config->get('open.auth_redirect', '');
        $query = http_build_query($params);

        if (!$params['redirect_uri']) {
            throw new \Exception('auth_redirect 不能为空', 40001);
        }

        return [
            'errcode' => 0,
            'authUrl' => $this->authUrl . '?' . $query
        ];
    }


    /**
     * 获取公众号授权信息
     *
     * @return array|bool|mixed
     */
    public function authAccessToken()
    {
        $comAccTk = $this->getRequestParams('authAccessToken', 'componentAccessToken');
        $params = $this->globalParams(['component_appid' => '']);
        $params['authorization_code'] = $this->getRequestParams('authAccessToken', 'authCode');

        $url = $this->authAccTk . '?component_access_token=' . $comAccTk;
        return ApiRequest::postRequest('authAccessToken', $url, $params);
    }

    /**
     * 刷新授权Access Token
     *
     * @return bool
     */
    public function refreshAuthAccessToken()
    {
        $comAccTk = $this->getRequestParams('refreshAuthAccessToken', 'componentAccessToken');
        $params = $this->globalParams(['component_appid' => '']);
        $params['authorizer_appid'] = $this->getRequestParams('refreshAuthAccessToken',
            'authAppId');
        $params['authorizer_refresh_token'] = $this->getRequestParams('refreshAuthAccessToken',
            'refreshToken');

        $url = $this->refAuthAccTk . '?component_access_token=' . $comAccTk;;
        return ApiRequest::postRequest('refreshAuthAccessToken', $url, $params);
    }

    /**
     * 获取授权方的帐号基本信息
     * @return array|bool|mixed
     */
    public function authorizeInfo()
    {
        $comAccTk = $this->getRequestParams('authorizeInfo', 'componentAccessToken');
        $params = $this->globalParams(['component_appid' => '']);
        $params['authorizer_appid'] = $this->getRequestParams('authorizeInfo', 'authAppId');

        $url = $this->authInfo . '?component_access_token=' . $comAccTk;
        return ApiRequest::postRequest('authAccessToken', $url, $params);
    }

    /**
     * 代公众号调用接口调用次数清零 API 的权限。
     * 每个公众号每个月有 10 次清零机会，包括在微信公众平台上的清零以及调用 API 进行清零
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function clearWeChatQuota()
    {
        $params['appid'] = $this->getRequestParams('clearWeChatQuota', 'appId');
        $accessToken = $this->getRequestParams('clearWeChatQuota', 'accessToken');

        $url = $this->clearQuota . '?access_token=' . $accessToken;
        return ApiRequest::postRequest('clearWeChatQuota', $url, $params);

    }

    /**
     * 第三方平台对其所有 API 调用次数清零（只与第三方平台相关，与公众号无关，接口如 api_component_token）
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function clearComponentQuota()
    {

        $accessToken = $this->getRequestParams('clearComponentQuota', 'componentAccessToken');
        $params = $this->globalParams(['component_appid' => '']);

        $url = $this->clearComponentQuota() . '?component_access_token=' . $accessToken;
        return ApiRequest::postRequest('clearComponentQuota', $url, $params);
    }

    /**
     * 授权公众号列表
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function authorizeList()
    {
        $comAccTk = $this->getRequestParams('authorizeList', 'componentAccessToken');
        $params = $this->globalParams(['component_appid' => '']);
        $params['offset'] = $this->getRequestParams('authorizeList', 'offset');
        $params['count'] = $this->getRequestParams('authorizeList', 'count');

        $url = $this->authorList . '?component_access_token=' . $comAccTk;;
        return ApiRequest::postRequest('authorizeList', $url, $params);
    }
}