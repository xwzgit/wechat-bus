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

        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));

        return ApiRequest::getRequest('getCustomMenus',$url);
    }

    /**
     * 自定义创建菜单
     *
     *
     * @param $buttons
     * @return array|mixed
     * @throws \Exception
     */
    public function createMenus( $buttons)
    {
        $url = ApiUrlConfig::configItem('menus.createMenus');
        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));

        return ApiRequest::postRequest('createMenus',$url,$buttons);
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
        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));

        return ApiRequest::getRequest('getMenus',$url,[]);

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
        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));

        return ApiRequest::getRequest('deleteMenus',$url);

    }

    /**
     * 创建个性化菜单
     *
     * @param $buttons
     * @return array|mixed
     * @throws \Exception
     */
    public function createConditionalMenus( $buttons)
    {
        $url = ApiUrlConfig::configItem('menus.conditionalMenus');
        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));

        return ApiRequest::postRequest('createConditionalMenus',$url,$buttons);
    }

    /**
     * 测试个性化菜单
     *
     *
     * @param $conditional
     * @return array|mixed
     * @throws \Exception
     */
    public function tryConditionalMenus($conditional)
    {
        $url = ApiUrlConfig::configItem('menus.testConditionalMenus');
        $url = $this->developUrl($url,$this->getRequestParams('getCustomMenus','accessToken'));

        return ApiRequest::postRequest('tryConditionalMenus',$url,$conditional);
    }

    /**
     * 删除个性菜单
     *
     * @param $accessToken
     * @param $conditional
     * @return array|mixed|string
     */
    public function deleteConditionalMenus($conditional)
    {
        $url = ApiUrlConfig::configItem('menus.deleteConditionalMenus');
        $url = $this->developUrl($url,$this->getRequestParams('deleteConditionalMenus','accessToken'));

        return ApiRequest::postRequest('createConditionalMenus',$url,$conditional);

    }
}