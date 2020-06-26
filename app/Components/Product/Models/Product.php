<?php

namespace App\Components\Product\Models;

// use App\Components\User\Models\Brand;
// use App\Components\User\Models\User;
// use Carbon\Carbon;
// use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @package App\Components\File\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property json $attributes
 * @property int $brand_id
 * @property int $category_id
 */
class Product extends Model
{
    protected $table = 'products';

    // Cast attributes JSON to array
    protected $casts = [
        'attributes' => 'array'
    ];

    protected $fillable = [
        'name',
        'description',
        'attributes',
        'brand_id',
        'category_id',
        'created_by',
        'uploaded_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'uploaded_by');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'brand_id');
    }
}
