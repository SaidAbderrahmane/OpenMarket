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
        $table->increments('id');
		$table->string('title',100);
		$table->string('slug',100);
		$table->string('subtitle',100);
		$table->string('description',250);
        $table->integer('price');
		$table->string('image',100)->default(Null);;
		$table->integer('categoryid')->unsigned()->nullable()->default(NULL);
		$table->integer('stock')->nullable()->default(0);
        $table->timestamps();
        $table->foreign('categoryid')
        ->references('id')
        ->on('categories')
        ->onDelete('cascade');
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
