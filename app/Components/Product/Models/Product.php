<?php

namespace App\Components\Product\Models;

use Illuminate\Database\Eloquent\Model;

use App\Components\User\Models\User;
use App\Components\Product\Models\Category;

class Product extends Model {

    protected $table = 'products';

    // Cast attributes JSON to array
    protected $casts = [
        'attributes' => 'array'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'attributes',
        'brand_id',
        'categories',
        'attributes',
    ];

    public static $rules = array(
        'name' => 'required',
        'attributes' => 'array',
    );

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
