##第三方平台授权（OpenApiService服务处理中心）
**所有的返回同微信第三方平台格式相同，如果请求失败，会抛出异常，请在接口调用的时候自行捕捉异常

####一、第三方平台ticket校验）
```
    第三方平台会推送事件给服务器：
    常规component_verify_ticket校验、公众号授权、取消授权、更改授权系信息
    
    //实例化ticket校验类
    $ticket = new Ticket(config('weChatBus'));
    
    //消息加解密处理
    $arrContent = $ticket->verifyTicket(); //消息处理（解密）
    
    //若无异常抛出，记录ticket返回success字符串
```


####二、第三方平台授权地址获取
```
    $verifyTicket = 获取微信服务器定时推送的最新ticket，通过ticket获取componentToken

    //第三方平台componentAccessTokne获取
    $response = OpenApiServer::componentAccessToken(config('weChatBus'),$verifyTicket)
    $response返回格式
    {
       "component_access_token": "61W3mEpU66027wgNZ_MhGHNQDHnFATkDa9-2llqrMBjUwxRSNPbVsMmyD-yq8wZETSoE5NQgecigDrSHkPtIYA",
       "expires_in": 7200,
       "errcode":0,
    }
    
    //预授权码获取
    $response = OpenApiServer::preAuthCode(config('weChatBus'),$comAccToken)
    $response返回格式
    {
        "errcode":0,
        "pre_auth_code": "Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw",
        "expires_in": 600
    }
    //获取第三方平台授权地址
    $response = OpenApiServer::createAuthUrl($result['pre_auth_code']);
    (如果需要记录授权发起人uid的话，可以在授权地址后追加uid $authUrl.='?userName='.$userName;
    在授权回调的时候进行username获取)
    $response返回格式
    {
        "errcode":0,
        "authUrl": "http://***",
    }
```
####三、授权成功回调

```
    $authCode = 获取回调地址参数auth_code;
    $userName = 获取回调地址参数username(如果有的话);
    
    //获取授权accessToken有效期7200秒，第三方平台代理公众号调用接口的时候需要用到，需要全服务器全局保存，定时刷新
    $response = OpenApiServer::authAccessToken(config('weChatBus'),$comAccessToken,$authCode);
    $response返回格式
    {
        "errcode":0,
        "authorization_info": {
            "authorizer_appid": "wxf8b4f85f3a794e77",
            "authorizer_access_token": "QXjUqNqfYVH0yBE1iI_7vuN_9gQbpjfK7hYwJ3P7xOa88a89-Aga5x1NMYJyB8G2yKt1KCl0nPC3W9GJzw0Zzq_dBxc8pxIGUNi_bFes0qM",
            "expires_in": 7200,
            "authorizer_refresh_token": "dTo-YCXPL4llX-u1W1pPpnp8Hgm4wpJtlR6iV0doKdY",
            "func_info": [
                  {
                        "funcscope_category": {
                          "id": 1
                        }
                  },
                  {
                        "funcscope_category": {
                          "id": 2
                        }
                  },
                  {
                        "funcscope_category": {
                          "id": 3
                        }
                  }
            ]
        }
    }

    $authInfo = $response['authorization_info'];//授权信息
    
    //刷新授权token，更新或存储的token有效期
    $response = OpenApiServer::refreshAuthAccessToken(config('weChatBus'),$comAccessToken,$accTk->appId,$accTk->accRefTk);
    $response返回格式
    {
        "errcode" : 0,
        "authorizer_access_token": "some-access-token",
        "expires_in": 7200,
        "authorizer_refresh_token": "refresh_token_value"
    }
    
    
    //根据授权信息获取公众号信息
    $response = OpenApiServer::authorizeInfo(config('weChatBus'),$comAccessToken,$response['authorizer_appid']);
    $response返回格式
    {
        "errcode":0,
        //授权公众号信息
        "authorizer_info": {
            "nick_name": "微信SDK Demo Special",
            "head_img": "http://wx.qlogo.cn/mmopen/GPy",
            "service_type_info": {
              "id": 2
            },
            "verify_type_info": {
              "id": 0
            },
            "user_name": "gh_eb5e3a772040",
            "principal_name": "腾讯计算机系统有限公司",
            "business_info": {
              "open_store": 0,
              "open_scan": 0,
              "open_pay": 0,
              "open_card": 0,
              "open_shake": 0
            },
            "alias": "paytest01",
            "qrcode_url": "URL",
        },
        //授权信息
        "authorization_info": {
            "authorization_appid": "wxf8b4f85f3a794e77",
            "func_info": [
              {
                "funcscope_category": {
                  "id": 1
                }
              },
              {
                "funcscope_category": {
                  "id": 2
                }
              }
            ]
        }
    }


    // 获取第三方平台代公众号清理接口请求次数
    $response = OpenApiServer::clearWeChatQuota(config('weChatBus'),$response['authorizer_appid'],$accessToken);
    $response返回格式
    {
        "errcode": 0,
        "errmsg": "ok"
    }
    //获取第三方平台清零接口调用次数
    $response = OpenApiServer::clearComponentQuota(config('weChatBus'),$comAccessToken);
    $response返回格式
    {
        "errcode": 0,
        "errmsg": "ok"
    }

```



## 公众号网页授权（原始公众号网页授权，第三方平台代替发起网页授权）

```
    1，//网页授权地址获取：(通过第三方平台代理发起授权的话配置里的third_authorized=1，否则通过配置文件里的公众号原生授权)
    $this->config = config('weChatBus');
  
    $response = WeChatAuthServer::getAuthCodeUrl($this->config);
    $response返回格式
    {
        "errcode": 0,
        "authUrl": "http://***"
    }

    
    2，//通过code获取网页授权access token(如果是第三方平台代理授权的话，需要传递：$componentAccessToken)
    
    $response = WeChatAuthServer::getAccessToken($config,$appId,$code,$componentAccessToken);
    $response返回格式
    {
        "errcode" : 0,
        "access_token": "some-access-token",
        "expires_in": 7200,
        "refresh_token": "refresh_token_value",
        "openid" => "openId",
        "scope" => "snsapi_base
    }
    
    3，通过openId和access token 获取用户信息
    $response = WeChatAuthServer::getUserInfo($config,$appId,$openId,$accessToken);
    $response返回格式
    {   
        "openid":" OPENID",
        " nickname": NICKNAME,
        "sex":"1",
        "province":"PROVINCE"
        "city":"CITY",
        "country":"COUNTRY",
        "headimgurl":       "http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
        "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
        "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
    }
```
## 公众号接口调用
```
    1，获取公众号基础token(用于公众号接口调用的令牌，如果授权给第三方平台，则是第三方平台的授权accessTOken)
       $response = WeChatTokenServer::getBasicAccessToken($config);
       $response返回格式
       {
            "access_token":"ACCESS_TOKEN",
            "expires_in":7200
        }
        //公众号授权给第三方平台的，可以通过获取授权accessToken代替
    
    2，通过accessToken 调用公众号的相关接口（例：jsticket获取）
        $response = WeChatTokenServer::getJsApiTicket($accessToken);
        {
            "errcode":0,
            "errmsg":"ok",
            "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
            "expires_in":7200
        }
        
    3，通过jsTicket组装分享配置
      $response =WeChatTokenServer::getShareSetting($ticket,$request->fullUrl());
      $response返回格式
      {
        "timestamp":12321312312,
        "nonceStr":12321312312,
        "signUrl":12321312312,
        "signature":12321312312,
        "errcode":0,
      }
      
    其他公众号接口调用类似

```
