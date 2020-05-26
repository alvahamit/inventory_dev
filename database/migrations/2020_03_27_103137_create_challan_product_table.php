<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallanProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('challan_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('item_name')->nullable();
            $table->string('item_unit')->nullable();
            $table->integer('quantity');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challan_product');
    }
}
