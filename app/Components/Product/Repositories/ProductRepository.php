<?php

/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 10/9/2017
 * Time: 10:02 PM
 */

namespace App\Components\Product\Repositories;


use App\Components\Core\BaseRepository;
use App\Components\Core\Utilities\Helpers;
use App\Components\Product\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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
    public function listProducts($params)
    {
        return $this->get($params, ['categories'], function ($q) use ($params) {
            //$name = Arr::get($params, 'name', null);
            $categoryIds = explode(',', Arr::get($params, 'category_id', ''));
            //$brandIds = explode(',', Arr::get($params, 'brand_id', ''));

            //if (!empty($name))
            //    $q->where('name', '%' . $name . '%');
            
            if (count($categoryIds) > 0 && !empty($categoryIds[0])) 
                $q->whereIn('category_id', $categoryIds);
           // if (count($brandIds) > 0 && !empty($brandIds[0])) 
          //      $q->whereIn('brand_id', $brandIds);
            return $q;
        });
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
    public function deleteRecordAndProduct($id)
    {
        /** @var Product $fileRecord */
        $fileRecord = $this->model->find($id);

        // delete the actual file
        Storage::delete($fileRecord->path);

        // delete record
        $fileRecord->delete();

        return true;
    }

    /**
     * list resource
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
     */
    public function index($params)
    {
        return $this->get($params, ['categories'], function ($q) use ($params) {
            //$name = Arr::get($params, 'name', null);
            $categoryIds = explode(',', Arr::get($params, 'category_id', ''));
            //$brandIds = explode(',', Arr::get($params, 'brand_id', ''));

            //if (!empty($name))
            //    $q->where('name', '%' . $name . '%');
            
            if (count($categoryIds) > 0 && !empty($categoryIds[0])) 
                $q->whereIn('category_id', $categoryIds);
           // if (count($brandIds) > 0 && !empty($brandIds[0])) 
          //      $q->whereIn('brand_id', $brandIds);
            return $q;
        });
    }
   /* public function index($params)
    {
        return $this->get($params,[],function($q) use ($params)
        {
            $name = Arr::get($params,'name',null);

            if($name) $q = $q->where('name','like',"%{$name}%");

            return $q;
        });
    }*/
}
