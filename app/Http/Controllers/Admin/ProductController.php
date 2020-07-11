<?php

namespace App\Http\Controllers\Admin;

use App\Components\Product\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends AdminController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = $this->productRepository->index($request->all());

        return $this->sendResponseOk($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = validator($request->all(), [
            'name' => 'string|required|unique:products|max:255',
            'description' => 'required',
            'attributes' => 'json',
            'categories' => 'array',
            'brand_id' => 'integer',
        ]);

        if ($validate->fails())
            return $this->sendResponseBadRequest($validate->errors()->first());

        $product = $this->productRepository->create($request->all());

        if (!$product)
            return $this->sendResponseBadRequest("Failed to create product.");

        $categories = $request->get('categories', []);
        if (count($categories)) {
            foreach ($categories as $categoryId => $shouldAttach) {
                if ($shouldAttach)
                    $product->categories()->attach($categoryId);
            }
        }

        return $this->sendResponseCreated($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = false;
        if (is_int($id)) {
            $result = $this->productRepository->getProduct($id);
        }
        return $result ?
            $this->sendResponseOk($product) :
            $this->sendResponseNotFound();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = validator($request->all(), [
            'name' => 'string|required|unique:products|max:255',
            'description' => 'required',
            'attributes' => 'json',
            'categories' => 'array',
            'brand_id' => 'integer'
        ]);

        if ($validate->fails())
            return $this->sendResponseBadRequest($validate->errors()->first());

        $payload = $request->all();

        $updated = $this->productRepository->update($id, $payload);

        if (!$updated)
            return $this->sendResponseBadRequest("Failed update");

        // re-sync categories

        /** @var Product $product */
        $product = $this->productRepository->find($id, ['categories']);

        $categoryIds = [];
        $categories = $request->get('categories', []);

        if (count($categories)) {
            foreach ($categories as $categoryId => $shouldAttach) {
                if ($shouldAttach)
                    $product->categories()->attach($categoryId);
            }
            $product->categories()->sync($categoryIds);
        }

        return $this->sendResponseUpdated();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);
        } catch (\Exception $e) {
            return $this->sendResponseBadRequest("Failed to delete");
        }

        return $this->sendResponseDeleted();
    }
}
