<?php

namespace App\Components\Product\Models;

use App\Components\Product\Models\Category;
use App\Components\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $casts = [
        'attributes' => 'array',
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'attributes',
        'brand',
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
