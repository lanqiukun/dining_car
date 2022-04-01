<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    public function getCreatedAtAttribute($created_at)
    {
        return date("Y-m-d H:i:s", strtotime($created_at));
    }

    public function getUpdatedAtAttribute($created_at)
    {
        return date("Y-m-d H:i:s", strtotime($created_at));
    }
     
}
