<?php

namespace App\Http\Controllers;

use App\Dishes;
use Illuminate\Http\Request;

class DishesCtrl extends Controller
{
    static public function top()
    {
        $top = Dishes::select(['id', 'imgSrc', 'title'])->orderBy('sales', 'desc')->take(3)->get()->toArray();

        return [
            'status' => 0,
            'top' => $top,
        ];
    }

    static public function all() 
    {
        $all = Dishes::select(['id', 'imgSrc', 'title', 'price'])->get()->toArray();

        foreach($all as &$item)
            $item['imgSrc'] = env('APP_URL') . 'backend/' . $item['imgSrc'];

        return [
            'status' => 0,
            'all' => $all,
        ];
    }
}
