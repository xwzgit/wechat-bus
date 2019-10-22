<?php
/**
 * 消息解密处理，
 * 消息封装
 *
 * User: owner
 * Date: 2017/11/27
 * Time: 12:01
 * Project Name: myWechat
 */
namespace WeChatBus\WeChat\Develop\ApiModels;



use WeChatBus\Support\Request\ApiRequest;
use WeChatBus\WeChat\Develop\Common\ApiUrlConfig;
use WeChatBus\WeChat\Develop\WeChatApi;

class TemplateMessage extends WeChatApi
{

    /**
     * 获取自定义模板列表
     *
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function getTemplateList()
    {
        $url = ApiUrlConfig::configItem('msgTpl.getTplList');


        return ApiRequest::getRequest('getTemplateList',$url,[
            'access_token' => $this->getRequestParams('getTemplateList','accessToken')
        ]);
    }

    /**
     * 删除模板
     *
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function removeTemplate()
    {
        $url = ApiUrlConfig::configItem('msgTpl.deleteTpl');
        $url = $this->developUrl($url,$this->getRequestParams('removeTemplate','accessToken'));

        $content = $this->getRequestParams('removeTemplate','content');
        return ApiRequest::postRequest('removeTemplate',$url,$content);
    }

    /**
     * 发送模板消息
     *
     *
     * @return array|mixed
     * @throws \Exception
     */
    public  function sendTemplateMessage()
    {
        $url = ApiUrlConfig::configItem('user.info');
        $sendMsg = $this->getRequestParams('sendTemplateMessage','post');


        $url = str_replace('{OPENID}', $sendMsg['touser'], $url);
        $response = ApiRequest::getRequest('userSubscribeInfo',$url,[
            'access_token' => $this->getRequestParams('getTemplateList','accessToken'),
            'openid' => $sendMsg['touser']
        ]);

        //已关注
        if(isset($response['subscribe'])) {
            //请求发送。。。。
            if($response['subscribe'] == 1) {

                $url = ApiUrlConfig::configItem('msgTpl.sendTplMsg');
                $url = $this->developUrl($url,$this->getRequestParams('sendTemplateMessage','accessToken'));

                return ApiRequest::postRequest('sendTemplateMessage',$url,$sendMsg);
            } else{
                throw new \Exception('用户未关注公众号',40000);
            }
        } else {
            throw new \Exception('用户未关注公众号',40000);
        }
    }

}