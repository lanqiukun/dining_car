<?php

namespace App\Http\Controllers;

use App\Dishes;
use Illuminate\Http\Request;

class DishesCtrl extends Controller
{
    static public function top()
    {
        $top = Dishes::select(['id', 'imgurl', 'title'])->orderBy('sales', 'desc')->take(3)->get()->toArray();

        return [
            'status' => 0,
            'top' => $top,
        ];
    }

    static public function new()
    {
        $new = Dishes::select(['id', 'imgurl', 'price', 'title'])->orderBy('created_at', 'desc')->take(3)->get()->toArray();

        return [
            'status' => 0,
            'new' => $new,
        ];
    }

    static public function all() 
    {
        $all = Dishes::select(['id', 'imgurl', 'title', 'price'])->get()->toArray();

        return [
            'status' => 0,
            'all' => $all,
        ];
    }

    static public function detail()
    {
        $id = request('id');

        $dishes = Dishes::find($id);

        return [
            'status' => 0,
            'dishes' => $dishes,
        ];
    }

}
