<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WechatCtrl extends Controller
{
    // 用AES解密算法解密用户的开放数据
    static function decryptData($sessionKey, $encryptedData, $iv)
    {
        $aesKey = base64_decode($sessionKey);

        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        return json_decode($result, true);        
    }

    // 获取sessionKey
    static public function jscode2session($code)
    {
        $appid = env("XCX_APPID");
        $app_secret = env("XCX_APPSECRET");

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$app_secret&js_code=$code&grant_type=authorization_code";
        $response = Http::get($url);

        $result = $response->json();
        
        return $result;
    }

    static public function get_access_token()
    {
        $appid = env("XCX_APPID");
        $app_secret = env("XCX_APPSECRET");

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$app_secret";

        $response = Http::retry(3, 3000)->get($url);

        $result = $response->json();

        return $result['access_token'];
    }

    static public function notify($order, $type)
    {

        $user = $order->user;

        $access_token = WechatCtrl::get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=$access_token";

        if ($type == 2) {
            $template_id = 'Uo1wzgNN4SpcKDU-_wka_2mZoA6ZQH7pgzPdN2gcLJI'; // 配送通知
            $data = [
                'character_string2' => ['value' => $order->order_no],
                'thing3' => ['value' => $order->position->location],
                'thing6' => ['value' => $order->dishes->title],
            ];
        }
        else if ($type == 3) {
            $template_id = 'jC_l1IX9RKWKzV0irDoW0qvvCqQ-b6nrZJWpkxdUM0k'; // 取餐提醒

            $data = [
                'thing2' => ['value' => $order->dishes->title],
                'thing4' => ['value' => $order->position->location],
            ];
        }

        

        $response = Http::retry(3, 3000)->post($url, [
            'touser' => $user->openid,
            'template_id' => $template_id,
            'page' => 'page/component/food/get?id=' . $order->id,
            'data' => $data,
            'miniprogram_state' => 'trial', //developer, trial, formal
            'lang' => 'zh_CN',
            
        ]);

        $result = $response->json();
        

    }
}
