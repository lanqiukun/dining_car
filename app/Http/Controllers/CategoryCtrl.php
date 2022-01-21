<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryCtrl extends Controller
{
    static public function all()
    {
        $categories = Category::with(['dishes'])->get();

        return [
            'status' => 0,
            'categories' => $categories,
        ];
    }
}
