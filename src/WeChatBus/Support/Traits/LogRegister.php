<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 2019-10-15
 * Time: 16:58
 * Project Name: openWeChat
 */

namespace WeChatBus\Support\Traits;


use Exception;
use WeChatBus\Support\Log\Log;

trait LogRegister
{

    /**
     * Register log service.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws Exception
     */
    protected function registerLogService()
    {
        //使用已授权第三方平台的公众号
        if($this->config->get('third_authorized')) {
            $this->config->get('open.token');
            $identify = 'weChatBus.open';
        } else {
            $this->config->get('weChat.token');
            $identify = 'weChatBus.weChat';

        }

        $logger = Log::createLogger(
            $this->config->get('log.file'),
            $identify,
            $this->config->get('log.level', 'warning'),
            $this->config->get('log.type', 'daily'),
            $this->config->get('log.max_file', 30)
        );

        Log::setLogger($logger);
    }

}