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

}
