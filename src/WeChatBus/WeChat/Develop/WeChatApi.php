<?php
/**
 * 公众号第三方平台接口调用服务
 *
 */

namespace WeChatBus\WeChat\Develop;


use WeChatBus\Support\Config\Config;
use WeChatBus\Support\Traits\BasicProcess;
use WeChatBus\Support\Traits\LogRegister;

class WeChatApi
{
    use BasicProcess,LogRegister;

    protected $config;
    protected $params;

    public function __construct($config)
    {
        $this->config = new Config($config);
        $this->registerLogService();
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