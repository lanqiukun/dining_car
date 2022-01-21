<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryCtrl extends Controller
{
    static public function all()
    {
        $categories = Category::select(['id', 'title'])->get();

        return [
            'status' => 0,
            'categories' => $categories,
        ];
    }

    static public function dishes()
    {
        $categories = Category::with(['dishes'])->get();

        foreach($categories as &$item) {
            $item->cate = $item->title . '系列';
            $item->detail = $item->dishes;
            unset($item->dishes);
        }

        return [
            'status' => 0,
            'categories' => $categories,
        ];
    }
}
