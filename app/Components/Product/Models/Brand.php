<?php

namespace App\Components\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Components\Product\Models
 *
 * @property int $id
 * @property string $name 
 */
class Brand extends Model
{
   protected $table = 'brands';

   protected $fillable = [
      'name'
   ];

   protected $appends = [
      'product_count'
   ];

   /**
    * get the product count attribute
    *
    * @return mixed
    */
   public function getProductCountAttribute()
   {
      return $this->products()->count();
   }

   /**
    * the products in this brand
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function products()
   {
      return $this->belongsToMany(Product::class);
   }
}
