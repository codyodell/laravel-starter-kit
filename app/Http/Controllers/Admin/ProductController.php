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

    public function index(Request $request)
    {
        $results = $this->productRepository->index($request->all());
        return $this->sendResponseOk($results);
    }

    public function store(Request $request)
    {
        $validate = validator($request->all(), [
            'name' => 'string|required|unique:products|max:255',
            'description' => 'required',
            'price' => 'float|required',
            'attributes' => 'json',
            'brand_id' => 'integer',
            'categories' => 'array|required',
            'created_by' => 'integer|required',
        ]);
        if ($validate->fails())
            return $this->sendResponseBadRequest($validate->errors()->first());
        $product = $this->productRepository->create($request->all());
        if (!$product)
            return $this->sendResponseBadRequest("Failed to create product.");
        $categories = $request->get('categories');
        if (count($categories)) {
            foreach ($categories as $categoryId => $shouldAttach) {
                if ($shouldAttach)
                    $product->categories()->attach($categoryId);
            }
        }
        return $this->sendResponseCreated($product);
    }

    public function show(int $id)
    {
        $result = $this->productRepository->find($id);
        return $result ?
            $this->sendResponseOk($result) :
            $this->sendResponseNotFound();
    }

    public function update(Request $request, $id)
    {
        $validate = validator($request->all(), [
            'name'          => 'string|required|unique:products|max:255',
            'description'   => 'required',
            'price'         => 'float|required',
            'attributes'    => 'json',
            'categories'    => 'array',
            'brand_id'      => 'integer',
            'created_by'    => 'integer',
        ]);

        if ($validate->fails())
            return $this->sendResponseBadRequest($validate->errors()->first());

        $payload = $request->all();

        if (!$this->productRepository->update($id, $payload))
            return $this->sendResponseBadRequest("Failed to Update Product");

        $product = $this->productRepository->find($id, ['categories', 'brand']);
        $categoryIds = [];
        $categories = $request->get('categories');

        foreach ($categories as $categoryId => $shouldAttach) {
            if ($shouldAttach) {
                $categoryIds[] = $categoryId;
                $product->categories()->attach($categoryId);
            }
        }

        if (count($categoryIds)) {
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
