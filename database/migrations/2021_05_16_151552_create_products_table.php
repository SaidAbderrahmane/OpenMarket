<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        $table->increments('ProductID');
		$table->string('ProductSKU',50);
		$table->string('ProductName',100);
		$table->float('ProductPrice');
		$table->float('ProductWeight');
		$table->string('ProductCartDesc',250);
		$table->string('ProductShortDesc',1000);
		$table->text('ProductLongDesc');
		$table->string('ProductThumb',100);
		$table->string('ProductImage',100);
		$table->integer('ProductCategoryID')->nullable()->default(NULL);
		$table->timestamp('ProductUpdateDate');
		$table->float('ProductStock')->nullable()->default(NULL);
		$table->tinyInteger('ProductLive')->default(0);
		$table->tinyInteger('ProductUnlimited')->default(0);
		$table->string('ProductLocation',250)->nullable()->default(NULL);
        $table->timestamps();
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
