<?php

namespace App\Http\Controllers;

use App\Order;
use App\Position;
use Illuminate\Http\Request;

class PositionCtrl extends Controller
{
    static public function all()
    {
        $positions = Position::all();

        return [
            'status' => 0,
            'positions' => $positions
        ];
    }

    static public function set_position()
    {
        $order_id = request("order_id");
        $position_id = request("position_id");

        $order = Order::find($order_id);

        if (!$order)
            return [
                'status' => 1,
                'msg' => '订单不存在'
            ];

        if ($order->user_id != request()->user->id)
            return [
                'status' => 1,
                'msg' => '您不能修改别人订单的配送地址'
            ];

        $position = Position::find($position_id);

        if (!$position)
            return [
                'status' => 1,
                'msg' => '餐车点不存在'
            ];

        $order->update(['position_id' => $position_id]);

        return [
            'status' => 0,
            'msg' => '操作成功'
        ];
    }
}
