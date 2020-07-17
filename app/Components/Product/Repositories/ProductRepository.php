<?php

namespace App\Components\Product\Repositories;

use App\Components\Core\BaseRepository;
use App\Components\Product\Models\Product;
use App\Components\Core\Utilities\Helpers;

use Illuminate\Support\Arr;

class ProductRepository extends BaseRepository
{
    // private MIN_SEARCH_QUERY_LENGTH = 3;

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function index($params)
    {
        return $this->get($params, ['categories', 'brand', 'user'], function ($q) use ($params) {
            $name           = Arr::get($params, 'name', '');
            $categories     = Arr::get($params, 'categories', '');
            $arCategoryIds = Helpers::commasToArray($categories);
            if (strlen($name) > 3) {
                $q->where('name', 'like', "%{ $name }%");
            }
            if (@count($arCategoryIds) > 0) {
                $q->whereIn('categories', function ($q) use ($arCategoryIds) {
                    return $q->whereIn('category_id', 'categories.id', $arCategoryIds);
                });
            }
            return $q;
        });
    }

    /**
    * list all products
    *
    * @param array $params
    * @return
    \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
    */
    public function listProducts($params)
    {
        return $this->get($params, ['categories', 'brand', 'created_by'], function ($q) use ($params) {
            $q->ofName($params['name'] ?? '');
            $q->ofCategories(Helpers::commasToArray(Arr::get($params, 'categories', '')));
            return $q;
        });
    }

    /**
     * @since  v1.0
     *
     * @param $id
     *
     * @return bool
     * @throws \Exception
     */

    public function delete(int $id)
    {
        $Product = $this->model->find($id);
        if (!$Product) 
            return false;
        $Product->categories()->detach();
        $Product->brand()->detach();
        $Product->user()->detach();
        return $Product->delete();
    }
}
