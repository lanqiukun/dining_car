<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dishes extends BaseModel
{
    protected $table = 'dishes';
    
    protected $appends = ['cover'];

    public function getCoverAttribute()
    {
        return env('APP_URL') . 'backend/' . $this->imgSrc;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
