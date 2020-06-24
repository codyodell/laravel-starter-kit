<?php

/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 10/10/2017
 * Time: 8:29 PM
 */

namespace App\Components\Product\Repositories;

use App\Components\Core\BaseRepository;
use App\Components\Product\Models\Category;
use Illuminate\Support\Arr;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * list resource
     *
     * @param array $params
     * @return CategoryRepository[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
     */
    public function index($params)
    {
        return $this->get($params, [], function ($q) use ($params) {
            $name = Arr::get($params, 'name', null);
            if ($name) 
                $q = $q->where('name', 'like', "%{$name}%");
            return $q;
        });
    }
}
