<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    protected $table = 'order';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status() 
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function dishes()
    {
        return $this->hasOne(Dishes::class, 'id', 'dishes_id');
    }
}
