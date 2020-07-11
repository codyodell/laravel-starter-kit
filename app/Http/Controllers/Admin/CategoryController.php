<?php

namespace App\Http\Controllers\Admin;

use App\Components\Product\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends AdminController
{
   /**
    * @var CategoryRepository
    */
   private $categoryRepository;

   /**
    * CategoryController constructor.
    * @param CategoryRepository $CategoryRepository
    */
   public function __construct(CategoryRepository $categoryRepository)
   {
      $this->categoryRepository = $categoryRepository;
   }

   /**
    * Display a listing of the resource.
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      $data = $this->categoryRepository->index($request->all());
      return $this->sendResponseOk($data);
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
         'name' => 'required|string|unique:categories|max:255',
         'description' => 'string',
      ]);

      if ($validate->fails())
         return $this->sendResponseBadRequest($validate->errors()->first());

      $category = $this->categoryRepository->create($request->all());

      return $category ?
         $this->sendResponseBadRequest("Failed to create.") :
         $this->sendResponseCreated($category);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(int $id)
   {
      $category = $this->categoryRepository->find($id);
      return $category ?
         $this->sendResponseOk($category) :
         $this->sendResponseNotFound();
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, int $id)
   {
      $validate = validator($request->all(), [
         'name' => 'required|string|unique:categories|max:255',
         'description' => 'string',
      ]);
      if ($validate->fails()) 
         return $this->sendResponseBadRequest($validate->errors()->first());
      $updated = $this->categoryRepository->update($id, $request->all());
      return $updated ?
         $this->sendResponseOk([], "Updated.") :
         $this->sendResponseBadRequest("Failed to update");
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(int $id)
   {
      $this->categoryRepository->delete($id);

      return $this->sendResponseOk([], "Deleted.");
   }
}
