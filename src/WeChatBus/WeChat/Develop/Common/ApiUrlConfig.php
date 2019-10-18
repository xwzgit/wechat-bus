<?php
/**
 * 获取微信开发的固有配置项 比如接口URL
 * User: owner
 * Date: 2017/11/27
 * Time: 13:04
 * Project Name: myWechat
 */

namespace WeChatBus\WeChat\Develop\Common;


class ApiUrlConfig
{
    /**
     * 获取公众号开发API地址
     *
     * @param string $item
     * @return array|mixed|string
     */
    public static function configItem($item = '')
    {
        if(file_exists(dirname(__FILE__).'/ApiUrls.php')) {
            $urls = include dirname(__FILE__).'/ApiUrls.php';
            if($item) {
                $items = explode('.',$item);
                $configs = [];
                foreach($items as $key => $filed) {
                    switch ($key) {
                        case '0':
                            if(isset($urls[$filed])) {
                                if(is_array($urls[$filed])) {
                                    $configs = $urls[$filed];
                                } else {
                                    return $url = $urls[$filed];
                                }
                            } else {
                                return '';
                            }
                            break;
                        case '1':
                            if(is_array($configs)) {
                                if(isset($configs[$filed])) {
                                    return $url = $configs[$filed];
                                }
                            }
                            return '';
                            break;
                    }
                }
            } else {
                return $urls;
            }

        } else {
            return [];
        }
    }
}