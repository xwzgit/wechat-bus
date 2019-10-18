<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 2019-10-15
 * Time: 16:58
 * Project Name: openWeChat
 */

namespace WeChatBus\Support\Traits;

use WeChatBus\Support\Log\Log;

trait BasicProcess
{
    /**
     * 获取参数
     *
     * @param $action
     * @param $index
     * @return bool
     */
    public function getRequestParams($action, $index)
    {
        if (isset($this->params[$index]) && ($this->params[$index] || $this->params[$index] === 0)) {
            return $this->params[$index];
        }

        Log::error($action, ['errcode' => 40001, 'errmsg' => $index . ' 参数不存在']);

        throw new \Exception($index . '=>参数不正确，请确认', 40001);

    }

    /**
     * 按需获取公共参数
     *
     * @param $params
     * @return array
     */
    public function globalParams($params)
    {
        $origin = [
            'component_appid' => $this->config->get('open.app_id'),
            'component_appsecret' => $this->config->get('open.app_secret'),
        ];

        return array_intersect_key($origin,$params);

    }

    /**
     * 获取配置项
     *
     * @param $key
     * @return mixed
     */
    public function getConfigItem($key)
    {
        return $this->config->get($key);
    }

    /**
     * 处理公众号开发接口
     *
     * @param $url
     * @param $token
     * @param string $kfAccount
     * @return mixed
     */
    public function developUrl($url,$token,$kfAccount = '')
    {
        if($kfAccount) {
            $url = str_replace('{KFACCOUNT}', $kfAccount, $url);
        }
        return str_replace('{ACCESS_TOKEN}', $token, $url);
    }

}