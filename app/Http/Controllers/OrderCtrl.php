<?php

namespace App\Http\Controllers;

use App\Dishes;
use App\Order;
use Illuminate\Http\Request;

class OrderCtrl extends Controller
{
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

    static public function list()
    {
        $user_id = request()->user->id;

        $orders = Order::with(['dishes'])->where('user_id', $user_id)->orderBy('id', 'desc')->get();

        return [
            'status' => 0,
            'orders' => $orders,
        ];

    }
}
