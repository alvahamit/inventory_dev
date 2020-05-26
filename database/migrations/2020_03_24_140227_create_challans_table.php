<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('challan_date');
            $table->string('challan_no')->index();
            $table->integer('challan_type')->unsigned();
            $table->integer('order_id')->unsigned()->nullable();
            $table->string('order_no')->index()->nullable();
            $table->string('quantity_type');
            $table->integer('store_id')->unsigned();
            $table->string('store_name')->nullable();
            $table->string('store_address')->nullable();
            $table->integer('to_store_id')->unsigned()->nullable();
            $table->string('to_store_name')->nullable();
            $table->string('to_store_address')->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->string('customer_name')->nullable();
            $table->string('delivery_address')->nullable();
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
        Schema::dropIfExists('challans');
    }
}
