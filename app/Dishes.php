<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dishes extends BaseModel
{
    protected $table = 'dishes';
    
    public function getImgurlAttribute($imgurl)
    {
        return env('APP_URL') . $imgurl;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
