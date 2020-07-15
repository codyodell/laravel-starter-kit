<?php

namespace App\Components\Product\Repositories;

use App\Components\Core\BaseRepository;
use App\Components\Product\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function index($params) {

        return $this->get($params, ['categories', 'brand'], function ($q) use ($params) {
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

    function getProduct (int $id = 0) {
        return $id ? 
            $this->model->find($id, ['categories']) : 
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
        if ($Product) {
            $Product->categories()->detach();
            return $Product->delete();
        }
    }
}
