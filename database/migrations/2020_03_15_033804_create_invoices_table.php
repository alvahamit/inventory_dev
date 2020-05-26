<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('invoice_date');
            $table->string('invoice_no');
            $table->string('order_no')->index();
            $table->integer('order_id')->unsigned()->index();
            $table->string('invoice_type');
            $table->string('quantity_type');
            $table->string('invoiced_by');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->string('billed_to');
            $table->float('discount')->default(0.00)->nullable();
            $table->float('carrying')->default(0.00)->nullable();
            $table->float('other_charge')->default(0.00)->nullable();
            $table->double('invoice_total',15,2);
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
        Schema::dropIfExists('invoices');
    }
}
