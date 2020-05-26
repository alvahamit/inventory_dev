<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no');
            $table->date('order_date');
            $table->integer('user_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_company');
            $table->string('customer_address1');
            $table->string('customer_address2');
            $table->string('shipp_to_name');
            $table->string('shipp_to_company');
            $table->string('shipping_address1');
            $table->string('shipping_address2');
            $table->string('quantity_type')->nullable();
            $table->double('order_total',15,2);
            $table->boolean('is_invoiced')->nullable();
            $table->string('order_status')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
