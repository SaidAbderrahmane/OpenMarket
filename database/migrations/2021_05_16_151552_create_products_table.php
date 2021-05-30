<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Null_;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('title')->unique();
        $table->string('slug')->unique();
        $table->string('subtitle');
        $table->text('description');
        $table->integer('price');
        $table->string('image');
		$table->unsignedInteger('stock')->default(0);
        $table->timestamps();
        //$table->bigInteger('category_id')->unsigned()->nullable()->default(NULL);
        // $table->foreign('categoryid')
        // ->references('id')
        // ->on('categories')
        // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
