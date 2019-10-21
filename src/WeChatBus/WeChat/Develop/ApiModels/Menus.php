<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 2017/11/27
 * Time: 12:01
 * Project Name: myWechat
 */
namespace WeChatBus\WeChat\Develop\ApiModels;


use WeChatBus\Support\Request\ApiRequest;
use WeChatBus\WeChat\Develop\Common\ApiUrlConfig;
use WeChatBus\WeChat\Develop\WeChatApi;

class  Menus  extends WeChatApi
{
    /**
     * 获取自定义菜单
     *
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function getCustomMenus()
    {
        $url = ApiUrlConfig::configItem('menus.menusInfo');

        return ApiRequest::getRequest('getCustomMenus',$url,[
            'access_token' => $this->getRequestParams('getCustomMenus','accessToken')
        ]);
    }

    /**
     * 自定义创建菜单
     *
     *
     * @param $buttons
     * @return array|mixed
     * @throws \Exception
     */
    public function createMenus()
    {
        $url = ApiUrlConfig::configItem('menus.createMenus');
        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));
        $buttons = json_encode($this->getRequestParams('getCustomMenus','buttons'),JSON_UNESCAPED_UNICODE);
        return ApiRequest::postRequest('createMenus',$url,$buttons,'body');
    }

    /**
     * 自定义菜单查询接口
     * 使用接口创建自定义菜单后，开发者还可使用接口查询自定义菜单的结构。
     * 另外请注意，在设置了个性化菜单后，使用本自定义菜单查询接口可以获取默认菜单和全部个性化菜单信息。
     *
     *
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function getMenus()
    {
        $url = ApiUrlConfig::configItem('menus.getMenus');

        return ApiRequest::getRequest('getMenus',$url,[
            'access_token' => $this->getRequestParams('getMenus','accessToken')
        ]);

    }

    /**
     * 自定义菜单删除
     * 使用接口创建自定义菜单后，开发者还可使用接口删除当前使用的自定义菜单。
     * 另请注意，在个性化菜单时，调用此接口会删除默认菜单及全部个性化菜单。
     *
     * @param $accessToken
     * @return array|mixed|string
     */
    public function deleteMenus()
    {
        $url = ApiUrlConfig::configItem('menus.deleteMenus');

        return ApiRequest::getRequest('deleteMenus',$url,[
            'access_token' => $this->getRequestParams('deleteMenus','accessToken')
        ]);

    }

    /**
     * 创建个性化菜单
     *
     * @param $buttons
     * @return array|mixed
     * @throws \Exception
     */
    public function createConditionalMenus()
    {
        $url = ApiUrlConfig::configItem('menus.conditionalMenus');
        $url = $this->developUrl($url,$this->getRequestParams('createConditionalMenus','accessToken'));


        $buttons = json_encode($this->getRequestParams('createConditionalMenus','buttons'),JSON_UNESCAPED_UNICODE);
        return ApiRequest::postRequest('createConditionalMenus',$url,$buttons,'body');
    }

    /**
     * 测试个性化菜单
     *
     *
     * @param $conditional
     * @return array|mixed
     * @throws \Exception
     */
    public function tryConditionalMenus()
    {
        $url = ApiUrlConfig::configItem('menus.testConditionalMenus');
        $url = $this->developUrl($url,$this->getRequestParams('tryConditionalMenus','accessToken'));


        $buttons = $this->getRequestParams('tryConditionalMenus','buttons');
        return ApiRequest::postRequest('tryConditionalMenus',$url,$buttons);
    }

    /**
     * 删除个性菜单
     *
     * @param $accessToken
     * @param $conditional
     * @return array|mixed|string
     */
    public function deleteConditionalMenus()
    {
        $url = ApiUrlConfig::configItem('menus.deleteConditionalMenus');
        $url = $this->developUrl($url,$this->getRequestParams('deleteConditionalMenus','accessToken'));


        $buttons = json_encode($this->getRequestParams('deleteConditionalMenus','buttons'),JSON_UNESCAPED_UNICODE);
        return ApiRequest::postRequest('deleteConditionalMenus',$url,$buttons,'body');

    }
}