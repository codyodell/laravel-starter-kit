<?php

namespace App\Components\Product\Repositories;

use App\Components\Core\BaseRepository;
use App\Components\Product\Models\Product;
use App\Components\Core\Utilities\Helpers;


class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function index($params) {

        return $this->get($params, ['categories', 'brand', 'user'], function ($q) use ($params) {
            $bFilterActive_Name     = isset($params['name']) && (strlen($params['name']) > 2);
            $bFilterActive_Category = isset($params['categories']) && !empty($params['categories']);
            $strName                = $bFilterActive_Name ? $params['name'] : '';
            $arCategoryIds          = $bFilterActive_Category ? explode(',', $params['categories']) : [];
            if ($bFilterActive_Name) {
                $q->where('name', 'like', "%{ $strName }%");
            }
            /*if ($bFilterActive_Category) {
                $q->whereIn('categories', function ($q) use ($arCategoryIds) {
                    return $q->whereIn('category_id', 'categories.id', $arCategoryIds);
                });
            }*/
            return $q;
        });
    }

    /**
    * list all users
    *
    * @param array $params
    * @return
    \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
    */
    public function listProducts($params)
    {
        return $this->get($params, ['categories', 'brand', 'user'], function ($q) use ($params) {
            $q->ofName($params['name'] ?? '');
            $q->ofCategories(Helpers::commasToArray($params['category_id'] ?? ''));
            return $q;
        });
    }

    function getProduct (int $id = 0) {
        return $id ? 
            $this->find($id, ['categories', 'brand', 'user']) : 
            false;
    }

    /**
     * @since  v1.0
     *
     * @param $id
     *
     * @return bool
     * @throws \Exception
     */

    public function delete(int $id = 0)
    {
        $Product = $this->model->find($id);
        if ($id && $Product) {
            $Product->categories()->detach();
            $Product->brand()->detach();
            $Product->user()->detach();
            return $Product->delete();
        }
    }
}
