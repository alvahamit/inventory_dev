<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_id');
            $table->integer('product_id');
            $table->integer('quantity')->comment('Qty. should be considered as the number of product package.');
            $table->float('unit_price')->comment('Unit is the package. So price should be package price.');
            $table->double('item_total',15,2);
            $table->date('manufacture_date')->nullable();
            $table->date('expire_date')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_purchase');
    }
}
