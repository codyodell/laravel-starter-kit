<?php

/* database/migrations/create_products */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name')->unique();
            $table->text('description');
            $table->json('attributes');
            // $table->unsignedInteger('brand_id')->index();
            // $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('created_by');
            $table->timestamps();

            // foreign key constraints
            // $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('created_by')->references('id')->on('users'); //->onDelete('restrict')->onUpdate('cascade');
            // $table->foreign('brand_id')->references('id')->on('brands'); //->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
