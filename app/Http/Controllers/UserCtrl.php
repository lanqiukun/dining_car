<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserCtrl extends Controller
{


    static public function login()
    {
        
        $code = request('code');
        $encryptedData = request('encryptedData');
        $iv = request('iv');

        $session = WechatCtrl::jscode2session($code);

        $openid = $session['openid'];
        $session_key = $session['session_key'];



        $user = User::where('openid', $openid)->first();

        if ($user)
            return [
                'status' => 0,
                'user' => $user
            ];
        


        $result = WechatCtrl::decryptData($session_key, $encryptedData, $iv);

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
