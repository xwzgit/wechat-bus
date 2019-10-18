<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */
namespace WeChatBus\WeChat\Token;

use WeChatBus\Support\Config\Config;
use WeChatBus\Support\Request\ApiRequest;
use WeChatBus\Support\Traits\BasicProcess;
use WeChatBus\Support\Traits\ShareSetting;

class BasicApi
{
    use BasicProcess;

    protected $config;
    protected $params;

    //获取公众号基础Access Token
    protected $basicAccessToken = "https://api.weixin.qq.com/cgi-bin/token";

    //js-sdk调用凭证jsapi ticket
    protected $jsApiTicket = "https://api.weixin.qq.com/cgi-bin/ticket/getticket";

    //拉取用户公众号信息，可做判断是否关注使用
    protected $weChatUser = 'https://api.weixin.qq.com/cgi-bin/user/info';

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
     * 获取公众号基础access token
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function getBasicAccessToken()
    {
        $params = [
            'appid' => $this->getConfigItem('weChat.app_id'),
            'secret' => $this->getConfigItem('weChat.app_secret'),
            'grant_type' => 'client_credential',
        ];

        return ApiRequest::getRequest('getBasicAccessToken',$this->basicAccessToken,$params);
    }

    /**
     * 获取JS-SDK Ticket
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function getJsTicketToken()
    {
        $params = [
            'access_token' => $this->getRequestParams('getJsTicketToken','accessToken'),
            'type' => 'jsapi',
        ];

        return ApiRequest::getRequest('getJsTicketToken',$this->jsApiTicket,$params);
    }


    /**
     * 获取分享配置
     *
     * @return array|bool|mixed|string
     * @throws \Exception
     */
    public function getShareSetting()
    {

        $share = [
            'timeStamp' => time(),
            'nonceStr' => ApiRequest::randString(32),
            'signUrl' => $this->getRequestParams('getShareSetting','signUrl'),
        ];

        //加密签名
        $query = [
            'jsapi_ticket' => $this->getRequestParams('getShareSetting','jsApiTicket'),
            'noncestr' => $share['nonceStr'],
            'timestamp' => $share['timeStamp'],
            'url' => $share['signUrl'],
        ];

        $query = ApiRequest::convertUrlParams($query);

        $share ['signature'] = sha1($query);
        $share ['errcode'] = 0;

        return $share;
    }

    /**
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function getWeChatAttentionInfo()
    {
        $params = [
            'access_token' => $this->getRequestParams('getWeChatUserByOpenId','accessToken'),
            'openid' => $this->getRequestParams('getWeChatUserByOpenId','openId'),
            'lang' => 'zh_CN',
        ];

        return ApiRequest::getRequest('getWeChatUserByOpenId',$this->weChatUser,$params);
    }
}