<?php

namespace App\Components\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Components\Product\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Category extends Model
{
   protected $table = 'categories';

   protected $fillable = [
      'name',
      'description'
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
    * the categories on this group
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function products()
   {
      return $this->belongsToMany(Product::class);
   }
}
