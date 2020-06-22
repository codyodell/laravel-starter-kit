<?php

namespace App\Components\Product\Models;

use App\Components\User\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
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
    const TAG = 'WASK_PRODUCT_MANAGER';

    // Cast attributes JSON to array
    protected $casts = [
        'attributes' => 'array'
    ];

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'attributes',
        'brand_id',
        'category_id',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Each product has a category
    public function category()
    {
        return $this->belongsTo('Category');
    }

    // Each product has a brand
    public function brand()
    {
        return $this->belongsTo('Brand');
    }
}
