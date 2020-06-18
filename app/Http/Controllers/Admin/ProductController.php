<?php

namespace App\Http\Controllers\Admin;

// use App\Components\Core\Result;
// use Illuminate\Http\Request;

use App\Components\Core\Utilities\Helpers;
use App\Components\Product\Models\Product;
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
            'name' => 'required',
            'description' => 'required',
            'attributes' => 'required|min:2',
            'categories' => 'array',
            'brand' => 'array',
        ]);

        if ($validate->fails()) return $this->sendResponseBadRequest($validate->errors()->first());

        /** @var Product $product */
        $product = $this->productRepository->create($request->all());

        if (!$product) return $this->sendResponseBadRequest("Failed create.");

        // attach to category
        if ($categories = $request->get('categories', [])) {
            foreach ($categories as $categoryId => $shouldAttach) {
                if ($shouldAttach) $product->categories()->attach($categoryId);
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
        $product = $this->productRepository->find($id, ['categories']);
var_dump($product);
        if (!$product) return $this->sendResponseNotFound();

        return $this->sendResponseOk($product);
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
            'name' => 'required',
            'description' => 'required',
            'attributes' => 'required|min:2',
            'categories' => 'array',
            'brand' => 'array'
        ]);

        if ($validate->fails()) return $this->sendResponseBadRequest($validate->errors()->first());

        $payload = $request->all();

        // if password field is present but has empty value or null value
        // we will remove it to avoid updating password with unexpected value
        if (!Helpers::hasValue($payload['password'])) unset($payload['password']);

        $updated = $this->productRepository->update($id, $payload);

        if (!$updated) return $this->sendResponseBadRequest("Failed update");

        // re-sync categories

        /** @var Product $product */
        $product = $this->productRepository->find($id);

        $categoryIds = [];

        if ($categories = $request->get('categories', [])) {
            foreach ($categories as $categoryId => $shouldAttach) {
                if ($shouldAttach) $categoryIds[] = $categoryId;
            }
        }

        $product->categories()->sync($categoryIds);

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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(Request $request)
    {
        $validate = validator($request->all(),[
            'title' => 'required|string',
            'description' => 'required|string',
            'key' => 'required|string|unique:permissions',
        ]);

        if($validate->fails()) return $this->sendResponseBadRequest($validate->errors()->first());

        $permission = $this->permissionRepository->create($request->all());

        if(!$permission) return $this->sendResponseBadRequest("Failed to create");

        return $this->sendResponseCreated($permission);
    }
    */
    // creates product in database
    // using form fields
    /*     public function store(Request $request){
        // create object and set properties
        $camera = new \App\Product();
        $camera->name = $request->name;
        $camera->brand_id = $request->brand_id;
        $camera->category_id = $request->category_id;
        $camera->attributes = json_encode([
            'processor' => $request->processor,
            'sensor_type' => $request->sensor_type,
            'monitor_type' => $request->monitor_type,
            'scanning_system' => $request->scanning_system,
        ]);
        // save to database
        $camera->save();
        // show the created camera
        return view('product.camera.show', ['camera' => $camera]);
    } */
}
