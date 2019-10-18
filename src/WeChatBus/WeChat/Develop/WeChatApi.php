<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus\WeChat\Develop;


use WeChatBus\Support\Config\Config;
use WeChatBus\Support\Traits\BasicProcess;
use WeChatBus\WeChat\Develop\ApiTraits\Menus;

class WeChatApi
{
    use BasicProcess,Menus;

    protected $config;
    protected $params;

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


}