<?php

namespace App\Http\Controllers\Admin;

use App\Components\Product\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends AdminController
{
   /**
    * @var BrandRepository
    */
   private $brandRepository;

   /**
    * BrandController constructor.
    * @param BrandRepository $BrandRepository
    */
   public function __construct(BrandRepository $brandRepository)
   {
      $this->brandRepository = $brandRepository;
   }

   /**
    * Display a listing of the resource.
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      $data = $this->brandRepository->index($request->all());

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
         'name' => 'required|string|unique:brands|max:255'
      ]);

      if ($validate->fails()) {
         return $this->sendResponseBadRequest($validate->errors()->first());
      }

      $brand = $this->brandRepository->create($request->all());

      if (!$brand) 
         return $this->sendResponseBadRequest("Failed to create.");

      return $this->sendResponseCreated($brand);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      $brand = $this->brandRepository->find($id);
      if (!$brand)
         return $this->sendResponseNotFound();
      return $this->sendResponseOk($brand);
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
         'name' => 'required|string|unique:brands|max:255'
      ]);

      if ($validate->fails())
         return $this->sendResponseBadRequest($validate->errors()->first());

      $updated = $this->brandRepository->update($id, $request->all());

      if (!$updated)
         return $this->sendResponseBadRequest("Failed to update");

      return $this->sendResponseOk([], "Updated.");
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $this->brandRepository->delete($id);

      return $this->sendResponseOk([], "Deleted.");
   }
}
