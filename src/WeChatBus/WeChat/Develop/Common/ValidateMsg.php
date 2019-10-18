<?php
/**
 * Created by PhpStorm.
 * User: owner
 * Date: 2018/9/20
 * Time: 17:20
 * Project Name: wechatConsole
 */

namespace WeChatBus\WeChat\Develop\Common;

use WeChatBus\Support\Crypt\SHA1;

class ValidateMsg
{
    public function validateToken($signature, $timestamp, $nonce, $token)
    {
        $sign = SHA1::getSHA1($token, $timestamp, $nonce, '');
        if ($sign['errcode'] == '0' && $signature == $sign['sha1']) {
            return true;
        } else {
            return false;
        }
    }
}