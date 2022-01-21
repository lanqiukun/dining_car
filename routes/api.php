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
});