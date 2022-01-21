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

        $order = Order::create([
            'user_id' => $user_id,
            'dishes_id' => $dishes_id,
        ]);

        Dishes::find($dishes_id)->increment('sales');

        return [
            'status' => 0,
            'msg' => '操作成功',
            'order' => $order,
        ];
    }
}
