<?php

/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 10/9/2017
 * Time: 10:02 PM
 */

namespace App\Components\Product\Repositories;

use App\Components\Core\BaseRepository;
use App\Components\Product\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * list all products
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
     */
    public function index($params) {
        return $this->get($params, ['categories'], function ($q) use ($params) {
            $bFilterActive_Name     = isset($params['name']) && (strlen($params['name']) > 2);
            $bFilterActive_Category = isset($params['categories']) && !empty($params['categories']);
            $strName                = $bFilterActive_Name ? $params['name'] : '';
            $arCategoryIds          = $bFilterActive_Category ? explode(',', $params['categories']) : [];

            if ($bFilterActive_Name) {
                $q->where('name', 'like', "%{$strName}%");
            }
            /*if ($bFilterActive_Category) {
                $q->whereIn('categories', function ($q) use ($arCategoryIds) {
                    return $q->whereIn('category_id', 'categories.id', $arCategoryIds);
                });
            }*/
            return $q;
        });
    }

    function getProduct (int $id ) {
        return $id ? $this->model->find($id, ['categories']) : false;
    }

    /**
     * @author darryldecode <darrylfernandez.com>
     * @since  v1.0
     *
     * @param $id
     *
     * @return bool
     * @throws \Exception
     */

    public function delete($id)
    {
        $Product = $this->model->find($id);
        if ($Product) {
            $Product->categories()->detach();
            return $Product->delete();
        }
    }
}
