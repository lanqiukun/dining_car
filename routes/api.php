<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', "UserCtrl@login");

Route::post('/simditor/upload', function() {

    $path = request()->upload_file->store('simditor');

    return [
        'status' => 0,
        'file_path' => '/' . $path,
    ];
});

Route::middleware(['check.token'])->group(function() {

    Route::post('submit_order', "OrderCtrl@submit_order");
    Route::get('order_list', "OrderCtrl@list");
    
    Route::post('set_position', "PositionCtrl@set_position");

});

Route::get('/all_dishes', "DishesCtrl@all");
Route::get('/top_dishes', "DishesCtrl@top");
Route::get('/new_dishes', "DishesCtrl@new");
Route::get('/dishes_detail', "DishesCtrl@detail");


Route::get('/all_category', "CategoryCtrl@all");
Route::get('/category_dishes', "CategoryCtrl@dishes");


Route::get('/all_position', "PositionCtrl@all");


Route::get('order_detail', "OrderCtrl@detail");
