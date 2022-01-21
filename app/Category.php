<?php

namespace App;

class Category extends BaseModel
{
    protected $table = 'category';

    public function dishes()
    {
        return $this->hasMany(Dishes::class, 'category_id', 'id');
    }
}
