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
}
