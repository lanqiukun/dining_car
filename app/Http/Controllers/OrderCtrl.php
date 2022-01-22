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

    static public function notify($order_id, $type)
    {


        $order = Order::with(['user'])->find($order_id);

        $access_token = WechatCtrl::get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=$access_token';

        Http::retry(3, 3000)->post($url, [
            [

            ]
        ]);

    }
}
