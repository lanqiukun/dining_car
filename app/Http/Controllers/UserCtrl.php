<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserCtrl extends Controller
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

    static public function jscode2session($code)
    {
        $appid = env("XCX_APPID");
        $app_secret = env("XCX_APPSECRET");

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$app_secret&js_code=$code&grant_type=authorization_code";
        $response = Http::get($url);

        $result = $response->json();
        
        return $result;
    }

    static public function login()
    {
        
        $code = request('code');
        $encryptedData = request('encryptedData');
        $iv = request('iv');

        $session = self::jscode2session($code);

        $openid = $session['openid'];
        $session_key = $session['session_key'];



        $user = User::where('openid', $openid)->first();

        if ($user)
            return [
                'status' => 0,
                'user' => $user
            ];
        


        $result = self::decryptData($session_key, $encryptedData, $iv);

        $user = User::create([
            'openid' => $openid,
            'nickname' => $result['nickName'],
            'avatar' => $result['avatarUrl'],
            'token' => bin2hex(openssl_random_pseudo_bytes(32)),
        ]);

        return [
            'status' => 0,
            'user' => $user
        ];
    
    }

}
