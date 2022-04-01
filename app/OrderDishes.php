<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDishes extends Model
{
    protected $table = 'order_dishes';
    public $timestamps = false;    
    protected $guarded = [];
}
