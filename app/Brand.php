<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // A brand has many products
    public function products(){
        return $this->hasMany('Product');
    }
}
