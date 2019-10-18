<?php
/**
 * 公众号开发的url配置文件
 * User: owner
 * Date: 2017/11/27
 * Time: 13:05
 * Project Name: myWechat
 */
return [
    'tuLing' => [
        //图灵机器人
        'url' => 'http://www.tuling123.com/openapi/api',
        'key' => '4d35faf26e1233757310f78d9591d925',
    ],
    'menus' => [
        'menusInfo' => 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token={ACCESS_TOKEN}',
        'createMenus' => 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token={ACCESS_TOKEN}',
        'getMenus' => 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token={ACCESS_TOKEN}',
        'deleteMenus' => 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={ACCESS_TOKEN}',
        'conditionalMenus' => 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token={ACCESS_TOKEN}',
        'deleteConditionalMenus' => 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token={ACCESS_TOKEN}',
        'testConditionalMenus' => 'https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token={ACCESS_TOKEN}'
    ],

    //消息处理，下线模板
    'msgTpl' => [
        'setIndustry' => 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token={ACCESS_TOKEN}',
        'getIndustry' => 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token={ACCESS_TOKEN}',
        'getTplId' => 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token={ACCESS_TOKEN}',
        'getTplList' => 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token={ACCESS_TOKEN}',
        'deleteTpl' => 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token={ACCESS_TOKEN}',
        'sendTplMsg' => 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={ACCESS_TOKEN}',
    ],

     //客服管理
    'customService' => [
        'accountAdd' => 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token={ACCESS_TOKEN}',
        'accountUpdate' => 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token={ACCESS_TOKEN}',
        'accountDelete' => 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token={ACCESS_TOKEN}',
        'accountImg' => 'https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token={ACCESS_TOKEN}&kf_account={KFACCOUNT}',
        'accountList' => 'https://api.weixin.qq.com/customservice/kfaccount/getkflist?access_token={ACCESS_TOKEN}',
    ],

    //客服消息
    'customMsg' => [
        'msgSend' => 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={ACCESS_TOKEN}',
        'msgTyping' => 'https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token={ACCESS_TOKEN}',
    ],
    //用户模块
    'user' => [
        'info' => 'https://api.weixin.qq.com/cgi-bin/user/info?access_token={ACCESS_TOKEN}&openid={OPENID}&lang=zh_CN',
        'qrCode' => 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={ACCESS_TOKEN}',
    ]
];