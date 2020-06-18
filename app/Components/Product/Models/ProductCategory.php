<?php

namespace App\Components\Product\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 * @package App\Components\Product\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class ProductCategory extends Model
{
   protected $table = 'categories';

   protected $fillable = [
      'name',
      'description'
   ];

   protected $appends = ['category_count'];

   /**
    * get the category count attribute
    *
    * @return mixed
    */
   public function getCategoryCountAttribute()
   {
      return $this->categories()->count();
   }

   /**
    * the categories on this group
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function categories()
   {
      return $this->hasMany(Category::class, 'category_id');
   }
}
