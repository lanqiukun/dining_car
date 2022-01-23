<?php

namespace App\Http\Controllers;

use App\Dishes;
use App\Order;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderCtrl extends Controller
{
    static public function get_food()
    {
        $order_id = request('order_id');
        $order = Order::find($order_id);

        if (!$order)
            return [
                'status' => 1,
                'msg' => '订单不存在',
            ];
        
        if ($order->user_id != request()->user->id)
            return [
                'status' => 1,
                'msg' => '你不能取走别人的外卖',
            ];
        
        $order->update(['status_id' => 4]);

        return [
            'status' => 0,
            'msg' => '操作成功'
        ];
    }

    static public function submit_order()
    {
        $user_id = request()->user->id;
        $dishes_id = request('dishes_id');
        $amount = request('amount');

        $order = Order::create([
            'user_id' => $user_id,
            'dishes_id' => $dishes_id,
            'amount' => $amount,
        ]);

        Dishes::find($dishes_id)->increment('sales', $amount);

        return [
            'status' => 0,
            'msg' => '操作成功',
            'order' => $order,
        ];
    }

    static public function detail()
    {
        $id = request('id');

        $order = Order::find($id);

        $position = Position::find($order->position_id);

        return [
            'status' => 0,
            'order' => $order,
            'position' => $position,
        ];
    }

    static public function list()
    {
        $user_id = request()->user->id;

        $orders = Order::with(['dishes', 'position'])->where('user_id', $user_id)->orderBy('id', 'desc')->get();

        return [
            'status' => 0,
            'orders' => $orders,
        ];

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
                'thing2' => ['value' => $order->position->location],
                'thing4' => ['value' => $order->dishes->title],
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
