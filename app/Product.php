<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Cast attributes JSON to array
    protected $casts = [
        'attributes' => 'array'
    ];

    // Each product has a brand
    public function brand(){
        return $this->belongsTo('Brand');
    }

    // Each product has a category
    public function category(){
        return $this->belongsTo('Category');
    }
}