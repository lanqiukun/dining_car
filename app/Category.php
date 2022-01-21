<?php

namespace App;

class Category extends BaseModel
{
    protected $table = 'category';

    public $appends = ['cid'];

    public function getBannerAttribute($banner)
    {
        return env('APP_URL') . $banner;
    }

    public function getCidAttribute()
    {
        return 'c' . strval($this->id);
    }

    public function dishes()
    {
        return $this->hasMany(Dishes::class, 'category_id', 'id');
    }
}
