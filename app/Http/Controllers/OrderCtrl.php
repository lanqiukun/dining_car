<?php

namespace App\Http\Controllers;

use App\Category;
use App\Dishes;
use App\Order;
use App\OrderDishes;
use App\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $user = request()->user;

        $lunch_box = request('lunch_box');
        
        $tableware_json = file_get_contents('php://input');
        $tableware = json_decode($tableware_json, true)['tableware'];

        $total_price = 0;
        foreach ($tableware as $item)
            $total_price += $item["price"] * $item["amount"];

        $total_price -= ($lunch_box - 1) * 10;

        if ($user->balance < $total_price)
            return [
                'status' => 1,
                'msg' => '账户余额不足'
            ];
    

        DB::beginTransaction();
        try {

            $order = Order::create([
                'user_id' => $user->id,
                'lunch_box' => $lunch_box,
                'cost' => $total_price,
            ]);
    
            foreach($tableware as $item) {
                OrderDishes::create([
                    'order_id' => $order->id,
                    'dishes_id' => $item['id'],
                    'amount' => $item['amount'],
                ]);
                
                Dishes::find($item['id'])->increment('sales', $item['amount']);
            }
            
            $user->update(['balance' => $user->balance - $total_price]);
            
        } catch (Exception $e) {
            logger($e->getMessage());

            DB::rollBack();

            return [
                'status' => 2,
                'msg' => '系统错误',
            ];
        }
        DB::commit();

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


}
